<?php

namespace SIGESRHI\AdminBundle\Controller;

use Doctrine\ORM\EntityRepository;
use SIGESRHI\AdminBundle\Entity\Refrenda;

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
      $uploadfile = __DIR__."\..\..\..\..\web\uploads\RefrendaTemp\ ".basename($_FILES['arch_refrenda']['name']);

      if ((move_uploaded_file($_FILES['arch_refrenda']['tmp_name'], $uploadfile)) AND ($max>$_FILES['arch_refrenda']['size']) AND ($_FILES['arch_refrenda']['type']=="application/vnd.ms-excel") ) {
          
          $fila = 0;
          $sinerrores=1;
          $msj="";
          if (($gestor = fopen($uploadfile, "r")) !== FALSE) {              
              while ((($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) AND ($sinerrores==1)) {
                 if($fila!=0){
                  //verificamos el año de la refrenda////
                  $entityRef = $this->getDoctrine()
                                        ->getRepository('AdminBundle:Refrenda')
                                        ->findOneByCodigolp($datos[11]);  
                  if(substr_compare(date('Y'),$datos[11], 0,4) != 0 ){
                    $sinerrores=0;
                    $msj="Refrenda no pertenece al año actual";
                  }
                  elseif( $entityRef!=null ){
                    $sinerrores=4;
                    $msj="Refrenda ya cargada";
                  }
                  else{
                    $entity  = new Refrenda();
                    $plaza = $this->fullUpperFromDb($datos[4]);
                    if(($totalblank=substr_count($datos[0]," "))>0){
                      $codigocortado = explode(" ", $datos[0]);
                      $codigoempleado=$codigocortado[$totalblank];
                    }else{
                      $codigoempleado=$datos[0];
                    }         
                    $entity->setCodigoempleado($codigoempleado);
                    $entity->setPartida($datos[1]);
                    $entity->setSubpartida($datos[2]);
                    $entity->setNombreempleado($this->fullUpperFromDb($datos[3]));                    
                    $entity->setSueldoactual($datos[5]);
                    $entity->setNombrecentro($this->fullUpperFromDb($datos[6])); 
                    $entity->setSalariominimo($datos[7]); 
                    $entity->setSalariomaximo($datos[8]); 
                    $entity->setUnidadpresupuestaria($this->fullUpperFromDb($datos[9])); 
                    $entity->setLineapresupuestaria($this->fullUpperFromDb($datos[10])); 
                    $entity->setCodigolp($datos[11]);
                    $entity->setNombreplaza($plaza);

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
                      if($entityRefAct!=null){
                        $entityRefAct->setPartida($datos[1]);
                        $entityRefAct->setSubpartida($datos[2]);
                        $entityRefAct->setSueldoactual($datos[5]);
                        $entityRefAct->setUnidadpresupuestaria($this->fullUpperFromDb($datos[9])); 
                        $entityRefAct->setLineapresupuestaria($this->fullUpperFromDb($datos[10])); 
                        $entityRefAct->setCodigolp($datos[11]);
                        $entityRefAct->setNombreplaza($plaza);

                        $em->persist($entityRefAct);
                      }
                      else{
                        $sinerrores=3;
                        $msj="Existe inconsistencia con las contrataciones actuales, CODEMPLEADO:".$codigoempleado;

                      }                        
                    }else{
                      $sinerrores=2;
                      $msj="Existe inconsistencia entre la Refrenda y Manual de Puestos, PLAZA:".$plaza;
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
            $this->get('session')->getFlashBag()->add('new','Archivo de Refrendas cargado correctamente');            
          elseif($sinerrores!=1)
            $this->get('session')->getFlashBag()->add('errornew',$msj);
          else
            $this->get('session')->getFlashBag()->add('errornew','Error al cargar el archivo');
      } else {
          if($max<$_FILES['arch_refrenda']['size']){
            $this->get('session')->getFlashBag()->add('errornew','El archivo es demasiado grande');
          }elseif($_FILES['arch_refrenda']['type'] != "application/vnd.ms-excel"){
            $this->get('session')->getFlashBag()->add('errornew','El archivo no corresponde al tipo (csv) requerido'.$_FILES['arch_refrenda']['type'].' ');
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

