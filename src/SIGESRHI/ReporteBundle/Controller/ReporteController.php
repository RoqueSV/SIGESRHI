<?php
namespace SIGESRHI\ReporteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JRU;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JdbcConnection;
use SIGESRHI\ReporteBundle\Controller\DefaultController;
use \Java;


class ReporteController extends Controller
{
	

   public function crearConexion() {
        
        $host = $this->container->getParameter('database_host');
        $user = $this->container->getParameter('database_user');
        $password = $this->container->getParameter('database_password');
        $port = $this->container->getParameter('database_port');
        $db = $this->container->getParameter('database_name');

        $Conn = new	JdbcConnection("org.postgresql.Driver","jdbc:postgresql://".$host.":".$port."/".$db,$user,$password);
        return $Conn;
    }

      
   public function ReporteSeguroVidaAction()
    {

     /* Obtengo parametros */
     $request = $this->getRequest();
     $idExp = $request->get('idexp');      
     $ruta = $request->get('ruta'); 

     $em = $this->getDoctrine()->getManager();
     $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idExp);

     //Incluimos camino de migas 
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("segurovida_consultar"));
     $breadcrumbs->addItem("Consultar seguro colectivo", $this->get("router")->generate($ruta, array("id"=>$request->get('id'))));
     $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_segurovida"));
     
     // Nombre reporte
     $filename= 'Seguro de vida.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/SeguroVida/Segurocolectivo_de_vida.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("id_exp", new java("java.lang.Integer", $idExp));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function ReporteSolicitudAction()
    {

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idSol=$request->get('idsol'); 
     $ruta = $request->get('ruta');          
     
    //Incluimos camino de migas 
     $em = $this->getDoctrine()->getManager();
     $solicitud = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($idSol);

     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     if($solicitud->getIdexpediente()->getTipoexpediente() == 'E'){
       $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
       $breadcrumbs->addItem("Listado de empleados", $this->get("router")->generate("solicitud_cempleado"));
     }
     else{
       $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
       $breadcrumbs->addItem("Listado de aspirantes", $this->get("router")->generate("solicitud_caspirante"));
     }
     $breadcrumbs->addItem("Consultar solicitud", $this->get("router")->generate($ruta,array("id"=>$idSol)));
     $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_solicitudempleo"));

     // Nombre reporte
     $filename= 'Solicitud de empleo.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/SolicitudEmpleo/SolicitudEmpleo.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("sol_empleo", new java("java.lang.Integer", $idSol));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


   public function ReportePruebaPsicologicaAction()
    {

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('idexp');
     $ruta=$request->get('ruta');           

     //Incluimos camino de migas
      $em = $this->getDoctrine()->getManager();
      $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idExp);
      
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
      $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
      if($expediente->getTipoexpediente() == 'E'){
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Listado de empleados", $this->get("router")->generate("pruebapsicologica"));
      }
      else{
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Listado de aspirantes", $this->get("router")->generate("pruebapsicologica"));
      }
      $breadcrumbs->addItem("Consultar prueba psicólogica", $this->get("router")->generate($ruta,array('id'=>$expediente->getIdpruebapsicologica()->getId(),'exp'=>$idExp)));
      $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_pruebapsicologica"));
     
     // Nombre reporte
     $filename= 'Prueba psicologica.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/PruebaPsicologica/pruebapsicologica.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("id_exp", new java("java.lang.Integer", $idExp));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

  public function ReporteAccionesAction()
    {

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('id');
     $idaccion=$request->get('tipo');

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("accionpersonal_cempleados"));
     $breadcrumbs->addItem("Consultar hoja de servicio", $this->get("router")->generate("accionpersonal_cacuerdos", array("id"=>$idExp)));
     $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_acciones"));


     if(isset($_GET['fechainicio'])){
     $fecha1=$request->get('fechainicio');           
     $fecha2=$request->get('fechafin');
     $cadena= "and fecharegistroaccion between '".$fecha1."' and '".$fecha2."' ";
    }
    else{
        $cadena="";
    }

     // Nombre reporte
     $filename= 'accionpersonal.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/HojadeServicio/Hojadeservicio_tipoaccion.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idexp", new java("java.lang.Integer", $idExp));
     $Parametro->put("accion", new java("java.lang.Integer", $idaccion));
     $Parametro->put("cadena", new java("java.lang.String", $cadena));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));

     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }



  public function ReporteHojaServicioAction()
    {

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('id');

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("accionpersonal_cempleados"));
     $breadcrumbs->addItem("Consultar hoja de servicio", $this->get("router")->generate("accionpersonal_cacuerdos", array("id"=>$idExp)));
     $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_hojaservicio"));

     if(isset($_GET['fechainicio'])){
     $fecha1=$request->get('fechainicio');           
     $fecha2=$request->get('fechafin');
     $cadena= "and fecharegistroaccion between '".$fecha1."' and '".$fecha2."' ";
    }
    else{
        $cadena="";
    }

     // Nombre reporte
     $filename= 'Hojadeservicio.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/HojadeServicio/Hojadeservicio.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idexp", new java("java.lang.Integer", $idExp));
     $Parametro->put("cadena", new java("java.lang.String", $cadena));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));

     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

  public function ReporteLicenciasAction()
    {

    //Incluimos camino de migas
      
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
      $breadcrumbs->addItem("Prueba psicólogica", $this->get("router")->generate("pruebapsicologica_index_edit"));
      $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_pruebapsicologica"));

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('id');

     if(isset($_GET['fechainicio'])){
     $fecha1=$request->get('fechainicio');           
     $fecha2=$request->get('fechafin');
     $cadena= "and fecharegistroaccion between '".$fecha1."' and '".$fecha2."' order by fecharegistroaccion";
    }
    else{
        $cadena="order by fecharegistroaccion";
    }

     // Nombre reporte
     $filename= 'Hojadeservicio.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/HojadeServicio/Hojadeservicio.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idexp", new java("java.lang.Integer", $idExp));
     $Parametro->put("cadena", new java("java.lang.String", $cadena));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));

     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


 }