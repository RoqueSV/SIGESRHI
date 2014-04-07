<?php

namespace SIGESRHI\AdminBundle\Controller;

use Doctrine\ORM\EntityRepository;
use SIGESRHI\AdminBundle\Entity\Refrenda;
use SIGESRHI\ExpedienteBundle\Entity\Accionpersonal;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
use SIGESRHI\ExpedienteBundle\Entity\Contratacion;
use SIGESRHI\ExpedienteBundle\Entity\Hojaservicio;
use SIGESRHI\AdminBundle\Entity\RefrendaAct;

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
    
//CARGA INICIAL DE DATOS SIGESRHI
    public function cargaInicialAction(){
      return $this->render('AdminBundle:Refrenda:carga_inicial.html.twig');
    }

    public function verificarCargaInicialAction(){
      $em = $this->getDoctrine()->getManager();
      $max = $this->get('request')->request->get('MAX_FILE_SIZE');
      $uploadfile = __DIR__."/../../../../web/uploads/RefrendaTemp/".basename($_FILES['arch_carga_incial']['name']);
      $BKdir = $this->get('kernel')->getRootDir()."/../web/uploads/";
      $sinerrores=0;
      $msj="";
      
      $plazas = $this->getDoctrine()->getRepository('AdminBundle:Plaza')->findAll();
      $centros= $this->getDoctrine()->getRepository('AdminBundle:Centrounidad')->findAll();

      if($plazas != null AND $centros != null){
        if ((move_uploaded_file($_FILES['arch_carga_incial']['tmp_name'], $uploadfile)) AND ($max>$_FILES['arch_carga_incial']['size']) AND (($_FILES['arch_carga_incial']['type']=="application/vnd.ms-excel") OR ($_FILES['arch_carga_incial']['type']=="text/csv") ) ) {
           //respaldo BD
          /*exec("cd ".$BKdir."");
          system("C:\BitNami\wappstack-5.4.24-0\postgresql\bin\pg_dump.exe -i -h localhost -p 5432 -U postgres -F c -b -v -f sigesrhi sigesrhi");
          echo "cd ".$BKdir."";
          echo "C:\BitNami\wappstack-5.4.24-0\postgresql\bin\pg_dump.exe -i -h localhost -p 5432 -U postgres -F c -b -v -f sigesrhi sigesrhi";
           $msj="REspaldo exitoso";*/
           ///////
           //if (($gestor = fopen($uploadfile, "r")) !== FALSE) {  
           $gestor = fopen($uploadfile, "r");
           $i=0; 
           while ((($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) AND ($sinerrores==0)) {
            //obtenemos el codigo del empleado
           if($i!=0 && $datos[0]!=" "){            
            if(($totalblank=substr_count($datos[1]," "))>0){
              $codigocortado = explode(" ", $datos[1]);
              $codigoempleado=$codigocortado[$totalblank];
            }else{
              $codigoempleado=$datos[1];
              //echo $codigoempleado;
            }

            if(strlen($codigoempleado)==5){
              //Verificamos si ya existe un expediente para el empleado
              $empleadofind = $this->getDoctrine()->getRepository('ExpedienteBundle:Empleado')->findOneByCodigoempleado($codigoempleado);
              if($empleadofind!=null){
                $expedientefind = $empleadofind->getIdexpediente();
                $usuariofind = $empleadofind->getIdusuario();
              } 
              else{
                $expedientefind = null;
                $usuariofind = null;
              }             
              //***busqueda en catalogos*******/
              $plaza = $this->fullUpperFromDb($datos[5]);
              $plazafind = $this->getDoctrine()->getRepository('AdminBundle:Plaza')->findOneByNombreplaza($plaza);
              $centroOk=$this->fullUpperFromDb($datos[29]);
              $unidadOk=$this->fullUpperFromDb($datos[35]);    

              //query para encontrar el centro
              $centrofind=null;
              $centros = $this->getDoctrine()->getRepository('AdminBundle:Centrounidad')->findAll();
              foreach ($centros as $centro) {
                //echo strtoupper(utf8_decode($centro->getNombrecentro()))."==".strtoupper($datos[29])."<br>";
                if(strtoupper(utf8_decode($centro->getNombrecentro())) ==strtoupper($datos[29])){
                  $centrofind= $centro;
                  $centrofind->getNombrecentro();
                }
              }
              //query para encontrar la unidad
              if($centrofind!=null){
                $unidades = $this->getDoctrine()->getRepository('AdminBundle:Unidadorganizativa')->findAll();
                foreach ($unidades as $unidad) {
                  if($this->fullUpperFromDb($unidad->getNombreunidad()) ==$unidadOk){
                    $unidadfind_band= $this->getDoctrine()->getRepository('AdminBundle:Unidadorganizativa')->find($unidad->getId());
                    if($unidadfind_band->getIdcentro()->getId() == $centrofind->getId() )
                      $unidadfind = $unidadfind_band;
                  }
                }
              }

              //$cf = $centrofind->getId();
              /*$unidadfind=null;
              if(count($idunidad)>0){
               //echo "entraaaaaaaaaaa";
                $unidadfind = $this->getDoctrine()->getRepository('AdminBundle:Unidadorganizativa')->find($idunidad[0]);
              }*/
              /***************************/


              //echo $codigoempleado;
              if($expedientefind == null){                
                //creamos el expediente
                $factual = new \Datetime(date('d-m-Y'));
                $expediente = new Expediente();                 
                $expediente->setTipoexpediente('E');
                $expediente->setFechaexpediente(new \Datetime($datos[23]));
                $em->persist($expediente);

                //Entidad Empleado
                $empleado = new Empleado();
                $empleado->setIdexpediente($expediente);
                $empleado->setCodigoempleado($codigoempleado);
                
               $userfind = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->findOneByUsername($codigoempleado);          
               if($userfind==null){
                  //- Inyección de dependencias
                 $userManager = $this->get('fos_user.user_manager');
                 $user = $userManager->createUser();

                 //- Datos para crear usuario por defecto
                 $correo = $datos[32];
                 $tempPassword = $codigoempleado; 
                 $usuario = $codigoempleado;

                 //Asignando variables
                 $user->setUsername($usuario);
                 $user->setPlainPassword($tempPassword);
                 $user->setEmail($correo);

                 $user->setEnabled(true); //Activado x defecto
                 $user->setRoles(array('ROLE_USER')); //Permisos
                 
                 /* Asigno rol "Empleado" */
                 
                 $rol = $em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName('Empleado');

                 $user->addGroup($rol); //Rol aplicacion           
                 $userManager->updateUser($user); //Guardar cambios
               }
               else{
                $user = $userfind;
               }        
               $empleado->setIdusuario($user); //Asignar usuario a empleado
               $em->persist($empleado);
               /*********************/            

               /***************Datos personales**************/              
               if($datos[4]!="" && $datos[14]!="" && $datos[15]!="" && $datos[16]!="" && $datos[17]!="" && $datos[18]!="" && $datos[19]!="" && $datos[20]!="" && $datos[21]!="" && $datos[22]!="" && $datos[23]!="" && $datos[24]!="" && $datos[25]!="" && $datos[29]!="" && $datos[30]!="" && $datos[31]!="" && $datos[32]!="" && $datos[33]!=""){                  
                  $nombreOk=$this->fullUpperFromDb($datos[4]);
                  /***************Hoja de servicio**************/              
                  $hojaservicio = new Hojaservicio();
                  $hojaservicio->setNombreempleado($nombreOk);
                  $hojaservicio->setDui($datos[14]);
                  $hojaservicio->setLugardui($datos[15]);
                  $hojaservicio->setLugarnac($datos[17]);
                  $hojaservicio->setFechanac(new \Datetime($datos[18]));
                  //estado civil : S,C,V,A,D
                  $estadosValidos = array("S","C","V","A","D");
                  if(in_array($datos[19],$estadosValidos)){
                    $hojaservicio->setEstadocivil($datos[19]);
                  }
                  else{
                    $sinerrores=5;
                    $msj="Error en Resgistro: ".$i.". No coincide estado civil";
                  }
                  $direccionCompleta = $datos[31].", ".$datos[30];
                  $hojaservicio->setDireccion($direccionCompleta);              
                  $hojaservicio->setTelefonofijo($datos[21]);
                  $hojaservicio->setEducacion($this->fullUpperFromDb($datos[22]));
                  $hojaservicio->setFechaingreso(new \Datetime($datos[23]));
                  $hojaservicio->setCargo($datos[24]);
                  $hojaservicio->setSueldoinicial($datos[25]);
                  $hojaservicio->setIsss($datos[26]);
                  $hojaservicio->setNit($datos[27]);
                  $hojaservicio->setDestacadoen($centroOk);
                  $hojaservicio->setIdexpediente($expediente);     

                  $em->persist($hojaservicio);
                  /***************Fin Hoja de servicio**************/

                  /***************Solicitud empleo**************/ 
                  $solicitudempleo = new Solicitudempleo();
                  /*****find plaza***/                  
                  if($plazafind != null){
                    $solicitudempleo->setIdplaza($plazafind);
                  }                  
                  else{
                    $msj="Error. Plaza no encontrada en manual: ".$plaza.". En registro: ".$i;
                    $sinerrores=7;
                  }                  
                  /****find municipio****/
                  //$municipiofind = $this->getDoctrine()->getRepository('ExpedienteBundle:Municipio')->findOneByNombremunicipio($datos[33]);
                  //query para encontrar la unidad
                  $municipioOK = $this->fullUpperFromDb($datos[33]);
                  $queryu = $em->createQuery('SELECT m.id as id FROM ExpedienteBundle:Municipio m WHERE upper(m.nombremunicipio) =:par')
                              ->setParameter('par',$municipioOK);
                  $idmunicipio = $queryu->getSingleResult();
                  $municipiofind=null;
                  if(count($idmunicipio)>0)
                    $municipiofind = $this->getDoctrine()->getRepository('ExpedienteBundle:Municipio')->find($idmunicipio['id']);

                  if($municipiofind != null){
                    $solicitudempleo->setIdmunicipio($municipiofind);
                  }
                  else{
                    $msj="Error. Municipio no encontrado: ".$datos[33].". En registro: ".$i;
                    $sinerrores=7; 
                  }                  
                  /****expediente***/
                  $solicitudempleo->setIdexpediente($expediente);                  
                  /****dependenciaparinst-centrode atencion**/                  
                  //$centrofind = $this->getDoctrine()->getRepository('AdminBundle:Centrounidad')->findOneByNombrecentro($centroOk);

                  if($centrofind != null){
                    $solicitudempleo->setDependenciaparinst($centrofind);
                  }
                  else{
                    $msj="Error. Centro no encontrado: ".$datos[29].". En registro: ".$i;
                    $sinerrores=7;
                  }

                  $solicitudempleo->setNumsolicitud("00-2014");
                  $solicitudempleo->setPrimerapellido(" ");
                  $solicitudempleo->setNombres(" ");
                  $solicitudempleo->setNombrecompleto($nombreOk);
                  $solicitudempleo->setColonia($datos[30]);
                  $solicitudempleo->setCalle($datos[31]);
                  $solicitudempleo->setEstadocivil($datos[19]);
                  $solicitudempleo->setTelefonofijo($datos[21]);
                  $solicitudempleo->setTelefonomovil(" ");
                  $solicitudempleo->setEmail($datos[32]);
                  $solicitudempleo->setLugarnac($datos[17]);
                  $solicitudempleo->setFechanac(new \Datetime($datos[18]));
                  $solicitudempleo->setDui($datos[14]);
                  $solicitudempleo->setLugardui($datos[15]);
                  $solicitudempleo->setFechadui(new \Datetime($datos[16]));
                  $solicitudempleo->setNit($datos[27]);                  
                  $solicitudempleo->setIsss($datos[26]);
                  $solicitudempleo->setNup($datos[28]);
                  $solicitudempleo->setNip($datos[34]);
                  $solicitudempleo->setSexo($datos[20]);                  
                  $solicitudempleo->setFotografia($codigoempleado);
                  $solicitudempleo->setFecharegistro(new \Datetime($datos[23]));                  
                  $solicitudempleo->setFechamodificacion($factual);

                  $em->persist($solicitudempleo);
                  /***************Fin Solicitud empleo**************/ 
                }
                else{
                  $sinerrores=6;
                  $msj="Faltan datos en Resgistro: ".$i;
                }

              }else{
                echo "Ya existe expediente, usuario, hojaservicio, empleado, solicitudempleo";
                $expediente = $expedientefind;                   
                $empleado = $empleadofind;                            
              }      

              /**************Llenamos la tabla refrendaAct************/
              $refrendaAct  = new RefrendaAct();
              //$centrofind = $this->getDoctrine()->getRepository('AdminBundle:Centrounidad')->findOneByNombrecentro($centroOk);              
              //$unidadfind = $this->getDoctrine()->getRepository('AdminBundle:Unidadorganizativa')->findOneByNombreunidad($unidadOk);
              if($plazafind == null){
                $msj="Error. Plaza no encontrada en Manual de Puestos: ".$plaza.". En registro: ".$i;
                $sinerrores=9;
              }              
              elseif($unidadfind == null){
                $msj="Error. Unidad Organizativa no encontrada: ".$datos[35]." En centro: ".$datos[29]."(".$centrofind->getId()."). En registro: ".$i;
                $sinerrores=9;
              }
              elseif($centrofind == null) {
                $msj="Error. Centro no encontrado: ".$datos[29].". En registro: ".$i;
                $sinerrores=9; 
              }
              else{
                //Registramos refrenda si no hay inconsistencias
                if($datos[2]!="" && $datos[3]!="" && $datos[6]!="" && $datos[10]!="" && $datos[11]!="" && $datos[12]!=""){
                  $refrendaAct->setIdempleado($empleado);
                  $refrendaAct->setIdplaza($plazafind);
                  $refrendaAct->setIdunidad($unidadfind);
                  $refrendaAct->setCodigoempleado($codigoempleado);
                  $refrendaAct->setPartida($datos[2]);
                  $refrendaAct->setSubpartida($datos[3]);
                  $refrendaAct->setSueldoactual($datos[6]);
                  $refrendaAct->setUnidadpresupuestaria($this->fullUpperFromDb($datos[10]));
                  $refrendaAct->setLineapresupuestaria($this->fullUpperFromDb($datos[11]));
                  $refrendaAct->setCodigolp($datos[12]);
                  $refrendaAct->setNombreplaza($plaza);
                  $refrendaAct->setTipo($datos[13]);

                  $em->persist($refrendaAct);


                  /**************Contratacion*******************/              
                  $contratacion  = new Contratacion();
                  //1-nombramiento, 2-contrato
                  $tipo=0;
                  if($datos[13]=="ls"){
                    $tipo=1;
                  }
                  elseif ($datos[13]=="c") {
                    $tipo=2;
                  }
                  else{
                    $msj="Error. Verifique los codigos de tipo de contratacion debe coincidir con 'ls' o 'c'. Registro:".$i;          
                    $sinerrores=8;
                  } 
                  //buscando el jefe
                  /*$jefefind=null;                 
                  if($datos[36]!="")
                    $jefefind = $this->getDoctrine()->getRepository('AdminBundle:RefrendaAct')->findOneByCodigoempleado($datos[36]);
                  else{
                    $jefefind = $refrendaAct;
                  }
                    
                  if($jefefind!=null OR $datos[36]==""){*/
                    $contratacion->setTipocontratacion($tipo);
                    $contratacion->setIdempleado($empleado);
                    $contratacion->setPuesto($refrendaAct);                  
                    //$contratacion->setPuestojefe($jefefind);
                    $contratacion->setSueldoinicial($datos[25]);
                    $contratacion->setHoraslaborales($datos[37]);
                    $contratacion->setJornadalaboral($datos[38]);
                    $contratacion->setFechainiciocontratacion(new \Datetime($datos[23]));

                    $em->persist($contratacion);
                    /*****************Generar Acuerdo***********************/
                    $accionpersonal  = new Accionpersonal;
                    $accionpersonal->setIdexpediente($expediente);
                    $accionpersonal->setFecharegistroaccion(new \Datetime($datos[23]));                    
                    
                    $tipoaccion = $em->getRepository('ExpedienteBundle:Tipoaccion')->find(6);
                    $tipoaccion2 = $em->getRepository('ExpedienteBundle:Tipoaccion')->find(7);
                    if($tipo == 1 && $tipoaccion != null){
                      //nombramiento
                      $numeroacuerdo="GA-".$i;                    
                      $accionpersonal->setNumacuerdo($numeroacuerdo);
                      $accionpersonal->setIdtipoaccion($tipoaccion);
                      $accionpersonal->setMotivoaccion("Acuerdo: ".$accionpersonal->getNumacuerdo()." - ".$plaza." - Se registra su nombramiento a partir del ".$datos[23]." como ".$plaza.".- Partida: ".$datos[2]." Subpartida: ".$datos[3]." con sueldo mensual de $".$datos[25]);
                      $em->persist($accionpersonal);
                    }
                    elseif($tipo == 2 && $tipoaccion2 != null){
                      //contratacion
                      if($datos[39]!=""){
                      $accionpersonal->setNumacuerdo($datos[39]);
                      $accionpersonal->setIdtipoaccion($tipoaccion2);
                      $accionpersonal->setMotivoaccion("Contrato No ".$accionpersonal->getNumacuerdo().", ".$plaza." - Se le contrata a partir del ".$datos[23]." al ____ según contrato No. ".$datos[39]." como ".$plaza." con sueldo mensual de $".$datos[25]);

                      $em->persist($accionpersonal);
                      }
                      else{
                        $msj="Error. ingrese el numero de contrato para el registro:".$i;
                        $sinerrores=12;     
                      }
                    }
                    else{
                      $msj="Error. Verifique catalogo tipoaccion y los codigos de contratacion ls o c. Registro:".$i;
                      $sinerrores=11;   
                    }
                /*}
                  else{
                    $msj="Error. Verifique los codigos ingresados para los jefes(".$datos[36]."), debe ingresarlos en orden jerarquico. Registro:".$i;          
                    $sinerrores=10; 
                  }*/
                  
                  /************Fin Contratacion**************/
                }
                else{
                  $msj="Error. Datos incompletos(ref) en registro: ".$i;
                  $sinerrores=9;   
                }
              }              
              
              //Verificamos que exista la plaza asignada
              /*$entityPlaza = $this->getDoctrine()
                                        ->getRepository('AdminBundle:Plaza')
                                        ->findOneByNombreplaza($plaza); 
              if($entityPlaza != null){
                //Solicitud de empleo
                $solicitudempleo = new Solicitudempleo();

                //Refrenda Act
                $refrendaAct = new RefrendaAct();
                //Contratacion
                $contratacion = new Contratacion();
              }else{
                $sinerrores=4;
                $msj="Plaza no encontrada en el Manual de Puestos del ISRI: ".$plaza;
              }*/
            }
            elseif($datos[1]=="" && $datos[2]!="" && $datos[3]!="" && $datos[5]!="" && $datos[10]!="" && $datos[11]!="" && $datos[12]!=""){
              /**************PLAZAS VACANTES*****************/
              $refrendaAct  = new RefrendaAct();
              $refrendaAct->setIdplaza($plazafind);              
              $refrendaAct->setPartida($datos[2]);
              $refrendaAct->setSubpartida($datos[3]);
              $refrendaAct->setUnidadpresupuestaria($this->fullUpperFromDb($datos[10]));
              $refrendaAct->setLineapresupuestaria($this->fullUpperFromDb($datos[11]));
              $refrendaAct->setCodigolp($datos[12]);
              $refrendaAct->setNombreplaza($plaza);
              $refrendaAct->setSueldoactual(0);

              $em->persist($refrendaAct);
            }
            else{
              $sinerrores=3;
              //o es una plaza vacante
              $msj="Codigo Inválido: ".$codigoempleado.". Registro:".$i;
            }
            $i++;
            }//fin if i==0 lee a excepcion de la primera linea
            else{
             $i++;
            }
           }//fin while leer lineas (empleados)          

        }else{
          $sinerrores=2;
          $msj="Error en Archivo";
        }

      }else{
        $sinerrores=1;
        $msj="No existen catalogos Plaza, Centros y RolEmpleado";
      }

      if($sinerrores==0){        
        $em->flush();
        $msj='CARGA CORRECTA';
        $this->get('session')->getFlashBag()->add('new',$msj);
      }
      else        
        $this->get('session')->getFlashBag()->add('errornew',$msj);          
      //echo $msj;
      return $this->redirect($this->generateUrl('cargar_inicial'));
    }//fin verificar carga inicial
      
      /*$empleadosA = $em->getRepository('ExpedienteBundle:Empleado')->findAll();
      $expedientesA = $em->getRepository('ExpedienteBundle:Expediente')->findAll();
      if($empleadosA==null AND $expedientesA==null ){
        if ((move_uploaded_file($_FILES['arch_carga_incial']['tmp_name'], $uploadfile)) AND ($max>$_FILES['arch_carga_incial']['size']) AND (($_FILES['arch_carga_incial']['type']=="application/vnd.ms-excel") OR ($_FILES['arch_carga_incial']['type']=="text/csv") ) ) {
          if (($gestor = fopen($uploadfile, "r")) !== FALSE) {              
                while ((($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) AND ($sinerrores==1)) {
                  //llenado de EXPEDIENTE
                  
                  //FIN EXPEDIENTE
                  
                }
          }
        }
      }
      else{
        $sinerrores=0;
        $msj="Existen datos de empleados y expedientes, antes realice un respaldo de estos y borrelos de la base de datos";
      }

    }*/

    function fullUpperFromDb($String1){
      $String = utf8_encode(strtoupper($String1));
      $String = str_ireplace(array("á","ã","à","â","ª","ä"),"A",$String);
      $String = str_replace(array("Á","Ã","À","Â","Ä"),"A",$String);      
      $String = str_replace(array("Í","Ì","Î","Ï"),"I",$String);
      $String = str_replace(array("í","ì","î","ï"),"I",$String);
      $String = str_replace(array("é","è","ê","ë"),"E",$String);
      $String = str_replace(array("É","È","Ê","Ë"),"E",$String);
      $String = str_replace(array("ó","ò","ô","õ","ö","º"),"O",$String);
      $String = str_replace(array("Ó","Ò","Ô","Õ","Ö"),"O",$String);
      $String = str_replace(array("ú","ù","û","ü"),"U",$String);
      $String = str_replace(array("Ú","Ù","Û","Ü"),"U",$String);
      //$String = str_replace(array("Ñ","ñ"),"Ñ",$String);
      $String = str_replace(array("[","^","´","`","¨","~","]"),"",$String);
      $String = str_replace("ç","c",$String);
      $String = str_replace("Ç","C",$String);
      $String = str_replace("Ý","Y",$String);
      $String = str_replace("ý","y",$String);

      return $String;
    }

}

