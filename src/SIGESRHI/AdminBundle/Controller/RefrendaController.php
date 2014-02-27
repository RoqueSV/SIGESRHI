<?php

namespace SIGESRHI\AdminBundle\Controller;

use Doctrine\ORM\EntityRepository;
use SIGESRHI\AdminBundle\Entity\Refrenda;
use SIGESRHI\ExpedienteBundle\Entity\Accionpersonal;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RefrendaController extends Controller
{
    public function indexAction()
    {
      //camino de migas
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
      $breadcrumbs->addItem("Cargar Refrenda", $this->get("router")->generate("refrenda_cargar"));

      return $this->render('AdminBundle:Refrenda:index.html.twig');
    }

    public function cargarAction()
    {
      //camino de migas
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));

      return $this->render('AdminBundle:Refrenda:cargar.html.twig');
    }

    public function verificarAction()
    {
      $em = $this->getDoctrine()->getManager();
      $max = $this->get('request')->request->get('MAX_FILE_SIZE');
      $uploadfile = __DIR__."/../../../../web/uploads/RefrendaTemp/".basename($_FILES['arch_refrenda']['name']);

      if ((move_uploaded_file($_FILES['arch_refrenda']['tmp_name'], $uploadfile)) AND ($max>$_FILES['arch_refrenda']['size']) AND (($_FILES['arch_refrenda']['type']=="application/vnd.ms-excel") OR ($_FILES['arch_refrenda']['type']=="text/csv") ) ) {
          
          $fila = 0;
          $sinerrores=1;
          $msj="";
          if (($gestor = fopen($uploadfile, "r")) !== FALSE) {              
              while ((($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) AND ($sinerrores==1)) {
                //se verifica que la fila no sea la primera y que este numerado el registro
                 if($fila!=0 AND $datos[0]!=""){
                  //verificamos el año de la refrenda////
                  $entityRef = $this->getDoctrine()
                                        ->getRepository('AdminBundle:Refrenda')
                                        ->findOneByCodigolp($datos[12]);  
                  if(substr_compare(date('Y'),$datos[12], 0,4) != 0 ){
                    $sinerrores=0;
                    $msj="Refrenda no pertenece al año actual";
                  }
                  elseif( $entityRef!=null ){
                    $sinerrores=4;
                    $msj="Refrenda ya cargada";
                  }
                  elseif($datos[13]!="ls" AND $datos[13]!="c"){
                    $sinerrores=5;
                    $msj="Los tipos de contrato no coinciden. Validos son (c: Contrato, ls: Ley de salario)".$datos[13]; 
                  }
                  else{
                    $entity  = new Refrenda();
                    $plaza = $this->fullUpperFromDb($datos[5]);
                    if(($totalblank=substr_count($datos[1]," "))>0){
                      $codigocortado = explode(" ", $datos[1]);
                      $codigoempleado=$codigocortado[$totalblank];
                    }else{
                      $codigoempleado=$datos[1];
                    }         
                    $entity->setCodigoempleado($codigoempleado);
                    $entity->setPartida($datos[2]);
                    $entity->setSubpartida($datos[3]);
                    $entity->setNombreempleado($this->fullUpperFromDb($datos[4]));                    
                    $entity->setSueldoactual($datos[6]);
                    $entity->setNombrecentro($this->fullUpperFromDb($datos[7])); 
                    $entity->setSalariominimo($datos[8]); 
                    $entity->setSalariomaximo($datos[9]); 
                    $entity->setUnidadpresupuestaria($this->fullUpperFromDb($datos[10])); 
                    $entity->setLineapresupuestaria($this->fullUpperFromDb($datos[11])); 
                    $entity->setCodigolp($datos[12]);
                    $entity->setNombreplaza($plaza);
                    $entity->setTipo($datos[13]);

                    $em->persist($entity);
                    //Actualizar RefrendaAct////
                    $entityPlaza = $this->getDoctrine()
                                        ->getRepository('AdminBundle:Plaza')
                                        ->findOneByNombreplaza($plaza);  
                    if($entityPlaza!=null){
                      $idPlaza = $entityPlaza->getId();
                      
                      $entityRefAct=$this->getDoctrine()
                          ->getRepository('AdminBundle:RefrendaAct')
                          ->findOneBy(array('codigoempleado'=>$codigoempleado,
                                         'idplaza'=>$idPlaza));                         
                      $entityRefActSinEmpleado=$this->getDoctrine()
                          ->getRepository('AdminBundle:RefrendaAct')
                          ->findOneBy(array('codigoempleado'=>null,
                                         'idplaza'=>$idPlaza));                         
                      if($entityRefAct!=null OR ($entityRefActSinEmpleado!=null AND $codigoempleado=='')){
                        if($entityRefAct!=null){
                          $entityRefAct->setPartida($datos[2]);
                          $entityRefAct->setSubpartida($datos[3]);
                          $entityRefAct->setSueldoactual($datos[6]);
                          $entityRefAct->setUnidadpresupuestaria($this->fullUpperFromDb($datos[10])); 
                          $entityRefAct->setLineapresupuestaria($this->fullUpperFromDb($datos[11])); 
                          $entityRefAct->setCodigolp($datos[12]);
                          $entityRefAct->setNombreplaza($plaza);
                          $entityRefAct->setTipo($datos[13]);

                          $em->persist($entityRefAct);
                        }
                        elseif($entityRefActSinEmpleado!=null){
                          $entityRefActSinEmpleado->setPartida($datos[2]);
                          $entityRefActSinEmpleado->setSubpartida($datos[3]);
                          $entityRefActSinEmpleado->setSueldoactual($datos[6]);
                          $entityRefActSinEmpleado->setUnidadpresupuestaria($this->fullUpperFromDb($datos[10])); 
                          $entityRefActSinEmpleado->setLineapresupuestaria($this->fullUpperFromDb($datos[11])); 
                          $entityRefActSinEmpleado->setCodigolp($datos[12]);
                          $entityRefActSinEmpleado->setNombreplaza($plaza);
                          $entityRefActSinEmpleado->setTipo($datos[13]);

                          $em->persist($entityRefActSinEmpleado);
                        }

                        //Crear acuerdo por refrenda para los empleados con LS
                        if($datos[13]=='ls' AND $entityRefAct!=null){
                        $freg = new \Datetime(date('d-m-Y'));
                        //$fhasta = strtotime('+1 year',strtotime($finicio));
                        $anyo = date("Y");
                        $finicio = "01 de Enero ";
                        $fhasta = "31 de Diciembre de ".$anyo;
                        $numAcuerdo="GA-001/".$anyo;
                        $entityAcu  = new Accionpersonal();
                        $entityTipoaccion = $this->getDoctrine()->getRepository('ExpedienteBundle:Tipoaccion')->findOneByNombretipoaccion('Refrenda');
                        $entityAcu->setIdtipoaccion($entityTipoaccion);
                        $entityAcu->setIdexpediente($entityRefAct->getIdempleado()->getIdexpediente());
                        $entityAcu->setFecharegistroaccion($freg);
                        $entityAcu->setNumacuerdo($numAcuerdo);
                        //Para ley de salario registramos acuerdo
                        
                          $entityAcu->setMotivoaccion("Acuerdo: ".$numAcuerdo." ".$plaza."- Se refrenda su nombramiento a partir del ".$finicio." al ".$fhasta.". En PDA: ".$datos[2]." SUB N°: ".$datos[3].". Sueldo: $".$datos[6].". En base al artículo 10 de la Ley de Presupuesto para el ejercicio Fiscal del ".$anyo." se le aumenta a su salario por efecto de la Ley de Escalafon a partir del ".$finicio." de ".$anyo);                        
                        $em->persist($entityAcu);
                        }
                        //Para contrato se obvia

                      }
                      else{
                        $sinerrores=3;
                        if($codigoempleado!="") 
                          $msj="Inconsistencia en el sistema, Empleado:".$codigoempleado." no se encuentra relacionado con la Plaza: ".$plaza;
                        else 
                          $msj="Inconsistencia entre la Refrenda y Manual de Puestos, PLAZA:".$plaza." no se encuentra";

                      }                        
                    }else{
                      $sinerrores=2;
                      $msj="Inconsistencia entre la Refrenda y Manual de Puestos, PLAZA:".$plaza;
                    }                      
                      
                  }

                 }else            
                    $fila++;                            
              }
              fclose($gestor);
              if($sinerrores==1){
                $em->flush();
                $exit=1;
              }else $exit=0;
          }
          else{
            $exit=0;
          }
          if($exit==1 AND $sinerrores==1)
            $this->get('session')->getFlashBag()->add('new','Archivo de Refrendas cargado correctamente - Acuerdos por refrenda por contratos de Ley de Salario Generados Automáticamente');            
          elseif($sinerrores!=1)
            $this->get('session')->getFlashBag()->add('errornew',$msj);
          else
            $this->get('session')->getFlashBag()->add('errornew','Error al cargar el archivo');
      } else {
          if($max<$_FILES['arch_refrenda']['size']){
            $this->get('session')->getFlashBag()->add('errornew','El archivo es demasiado grande');
          }elseif($_FILES['arch_refrenda']['type'] != "application/vnd.ms-excel"){
            $this->get('session')->getFlashBag()->add('errornew','El archivo no corresponde al tipo (csv) requerido '.$_FILES['arch_refrenda']['type'].' ');
          }else{
            $this->get('session')->getFlashBag()->add('errornew','Errores en la carga del Archivo');
          }
      }

      //return $this->render('AdminBundle:Refrenda:cargar.html.twig');
      return $this->redirect($this->generateUrl('refrenda_cargar'));
    }

    function fullUpperFromDb($String1){
      $String = utf8_encode(strtoupper($String1));
      $String = str_ireplace(array("á","à","â","ã","ª","ä"),"A",$String);
      $String = str_replace(array("Á","À","Â","Ã","Ä"),"A",$String);
      $String = str_replace(array("Í","Ì","Î","Ï"),"I",$String);
      $String = str_replace(array("í","ì","î","ï"),"I",$String);
      $String = str_replace(array("é","è","ê","ë"),"E",$String);
      $String = str_replace(array("É","È","Ê","Ë"),"E",$String);
      $String = str_replace(array("ó","ò","ô","õ","ö","º"),"O",$String);
      $String = str_replace(array("Ó","Ò","Ô","Õ","Ö"),"O",$String);
      $String = str_replace(array("ú","ù","û","ü"),"U",$String);
      $String = str_replace(array("Ú","Ù","Û","Ü"),"U",$String);
      $String = str_replace(array("[","^","´","`","¨","~","]"),"",$String);
      $String = str_replace("ç","c",$String);
      $String = str_replace("Ç","C",$String);
      $String = str_replace("Ý","Y",$String);
      $String = str_replace("ý","y",$String);

      return $String;
    }   
}

