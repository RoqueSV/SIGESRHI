<?php
namespace SIGESRHI\ReporteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JRU;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JdbcConnection;
use SIGESRHI\ReporteBundle\Controller\DefaultController;
use \Java;

/* Para generar memorandum */
use Symfony\Component\HttpFoundation\Request;
use SIGESRHI\ExpedienteBundle\Entity\Memorandum;
use SIGESRHI\ExpedienteBundle\Form\MemorandumType;
/* *********************** */


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
     $vista = $request->get('vista');   
     $nogrid = $request->get('nogrid');       
     
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
     $breadcrumbs->addItem("Consultar solicitud", $this->get("router")->generate($ruta,array("id"=>$idSol,"vista_retorno"=>$vista,"nogrid"=>$nogrid)));
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
        $breadcrumbs->addItem("Consultar prueba psicólogica", $this->get("router")->generate($ruta,array('id'=>$expediente->getIdpruebapsicologica()->getId(),'exp'=>$idExp,'noasp'=>1)));
      }
      else{
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Listado de aspirantes", $this->get("router")->generate("pruebapsicologica"));
        $breadcrumbs->addItem("Consultar prueba psicólogica", $this->get("router")->generate($ruta,array('id'=>$expediente->getIdpruebapsicologica()->getId(),'exp'=>$idExp)));
      }
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
     $vista_retorno=$request->get('vista_retorno');

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("accionpersonal_cempleados"));
     $breadcrumbs->addItem("Consultar hoja de servicio", $this->get("router")->generate("accionpersonal_cacuerdos", array("id"=>$idExp, 'vista_retorno'=>$vista_retorno)));
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
     $vista_retorno=$request->get('vista_retorno');

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("accionpersonal_cempleados"));
     $breadcrumbs->addItem("Consultar hoja de servicio", $this->get("router")->generate("accionpersonal_cacuerdos", array("id"=>$idExp, 'vista_retorno'=>$vista_retorno)));
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
     
     /* Obtengo parametros */
     $request=$this->getRequest();
     $idcontrato=$request->get('id');

     $em = $this->getDoctrine()->getManager();
     $contratacion = $em->getRepository('ExpedienteBundle:Contratacion')->find($idcontrato);

     //Incluimos camino de migas

     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("licencia_ver"));
     $breadcrumbs->addItem("Consultar permisos", $this->get("router")->generate("licencia_ver_permisos", array("id"=>$contratacion->getIdempleado()->getIdexpediente()->getId(),"idc"=>$idcontrato)));
     $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_hojaservicio"));

     if(isset($_GET['fechainicio'])){
     $fecha1=$request->get('fechainicio');           
     $fecha2=$request->get('fechafin');
     $cadena= "and fechainiciolic between '".$fecha1."' and '".$fecha2."'";
    }
    else{
        $cadena="";
        $fecha1="";           
        $fecha2="";
    }

     // Nombre reporte
     $filename= 'Licenciasempleado.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/HojadeServicio/reporte_licenciasdeempleado.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idcontratacion", new java("java.lang.Integer", $idcontrato));
     $Parametro->put("cadena", new java("java.lang.String", $cadena));
     $Parametro->put("fechainicio", new java("java.lang.String", $fecha1));
     $Parametro->put("fechafin", new java("java.lang.String", $fecha2));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));

     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

public function ReporteCertificacionAction()
    {
     
     /* Obtengo parametros */
     $request=$this->getRequest();
     $idexp=$request->get('id');
     $vista_retorno=$request->get('vista_retorno');

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
     $breadcrumbs->addItem("Lista de empleados", $this->get("router")->generate("accionpersonal_cempleados"));
     $breadcrumbs->addItem("Consultar hoja de servicio", $this->get("router")->generate("accionpersonal_cacuerdos", array("id"=>$idexp, 'vista_retorno'=>$vista_retorno)));
     $breadcrumbs->addItem("Reporte certificación", $this->get("router")->generate("reporte_hojaservicio"));


     // Nombre reporte
     $filename= 'Certificacion_hojaservicio.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/HojadeServicio/Certificacion_hojadeservicio.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idexp", new java("java.lang.Integer", $idexp));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));

     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function concursoInternoAction()
    {

     $em = $this->getDoctrine()->getManager();
     
     /* Obtengo parametros */
     $request=$this->getRequest();
     $idconcurso=$request->get('id'); 

     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
     $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
     $breadcrumbs->addItem("Datos de concurso", $this->get("router")->generate("concurso_show",array('id'=>$idconcurso,'interesados'=>$request->get('interesados'))));
     $breadcrumbs->addItem("Cartel de concurso", $this->get("router")->generate("concurso"));

     // Nombre reporte
     $filename= 'Cartel concurso.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Memorandum/Cartel/rpt_informacionplaza.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idconcurso", new java("java.lang.Integer", $idconcurso));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function memoConcursoAction()
    {
     $em = $this->getDoctrine()->getManager();

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idconcurso  = $request->get('id'); 
     $correlativo = $request->get('correlativo');
     $interesados = $request->get('interesados');
     
      // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
     $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
     $breadcrumbs->addItem("Datos de concurso", $this->get("router")->generate("concurso_show",array('id'=>$idconcurso,'interesados'=>$interesados)));
     $breadcrumbs->addItem("Memorándum de concurso", $this->get("router")->generate("concurso"));

     
     // Nombre reporte
     $filename= 'Memorandum concurso.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Memorandum/AperturaConcurso/Memoconcurso.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idconcurso", new java("java.lang.Integer", $idconcurso));
     $Parametro->put("correlativo", new java("java.lang.String", $correlativo));
     $Parametro->put("interesados", new java("java.lang.String", $interesados));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function memoCierreAction()
    {
     $em = $this->getDoctrine()->getManager();

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idconcurso  = $request->get('id'); 
     $correlativo = $request->get('correlativo');
     $interesado = $request->get('interesado');
     $cargo = $request->get('cargo');
     $num = $request->get('num');

     if($num == 0){
      $caso = 'N';
     }
     else{
      $caso = 'A';
     }

     // Incluimos camino de migas
    $breadcrumbs = $this->get("white_october_breadcrumbs");
    $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
    $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
    $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
    $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$idconcurso)));
    $breadcrumbs->addItem("Memorandum de cierre", $this->get("router")->generate("concurso_consultar"));

     
     // Nombre reporte
     $filename= 'Memorandum de cierre.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Memorandum/CierreConcurso/Memocierre.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idconcurso", new java("java.lang.Integer", $idconcurso));
     $Parametro->put("correlativo", new java("java.lang.String", $correlativo));
     $Parametro->put("interesado", new java("java.lang.String", $interesado));
     $Parametro->put("cargointeres", new java("java.lang.String", $cargo));
     $Parametro->put("caso", new java("java.lang.String", $caso));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

    public function actaCierreAction()
    {
     $em = $this->getDoctrine()->getManager();

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idconcurso  = $request->get('id'); 
     $num = $request->get('num');

     if($num == 0) {
        $naplicantes = 'N';
    }
     else{
        $naplicantes = 'A';
    }

    // Incluimos camino de migas
    $breadcrumbs = $this->get("white_october_breadcrumbs");
    $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
    $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
    $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
    $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$idconcurso)));
    $breadcrumbs->addItem("Acta de cierre", $this->get("router")->generate("concurso_consultar"));

     
     // Nombre reporte
     $filename= 'Acta de cierre.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Memorandum/ActaCierre/acta_cierreconcurso.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idconcurso", new java("java.lang.Integer", $idconcurso));
     $Parametro->put("n_aplicantes", new java("java.lang.String", $naplicantes));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function generarMemorandumAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tipomemo  = $request->get('tipomemo');
       
        /**** Persistencia del memorándum ***/
        $entity  = new Memorandum();
        $form = $this->createForm(new MemorandumType(), $entity);
        
        $correlativo = $this->correlMemorandum(); //Correlativo de memorandum
        $entity->setCorrelativo($correlativo);
        $entity->setTipomemorandum($tipomemo);

        $form->bind($request); //Enlazar datos del form con la entidad para validar

        $idempleado  = $form->get('empleado')->getData();
        $empleado    = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);
        $idhoja = $empleado->getIdexpediente()->getHojaservicio()->getId();

        /* *** Obtener titulo *** */
        $query = $em->createQuery(
                 "SELECT (case when upper(hs.educacion) like upper ('%Ingenie%') then 'Ingeniero(a)' 
                               when upper(hs.educacion) like upper ('%Licencia%') then 'Licenciado(a)' 
                               when upper(hs.educacion) like upper ('%Doctor%') then 'Doctor(a)'
                               when upper(hs.educacion) like upper ('%Profesorado%') then 'Profesor(a)'
                               else 'Sr(a).'
                               end) as titulo
                  FROM ExpedienteBundle:Hojaservicio hs 
                  WHERE hs.id =:idhoja")
                 ->setParameter('idhoja', $idhoja); 
        $resultado = $query->getSingleResult();
        $titulo=$resultado['titulo'];

         $nombreempleado = $titulo." ".$empleado->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto();

        /* ********************* */

        $cargo     = $form->get('cargo')->getData();       
        $asunto    = $form->get('asunto')->getData();
        $contenido = $form->get('contenido')->getData();
        

        if($tipomemo == '2'){ // Es de tipo "a través de"
            $atraves   = $form->get('atraves')->getData();
            $empleado2 = $em->getRepository('ExpedienteBundle:Empleado')->find($atraves);
            $idhoja2 = $empleado2->getIdexpediente()->getHojaservicio()->getId();

            /* *** Obtner titulo *** */
            $query = $em->createQuery(
                 "SELECT (case when upper(hs.educacion) like upper ('%Ingenie%') then 'Ingeniero(a)' 
                               when upper(hs.educacion) like upper ('%Licencia%') then 'Licenciado(a)' 
                               when upper(hs.educacion) like upper ('%Doctor%') then 'Doctor(a)'
                               when upper(hs.educacion) like upper ('%Profesorado%') then 'Profesor(a)'
                               else 'Sr(a).'
                               end) as titulo
                  FROM ExpedienteBundle:Hojaservicio hs 
                  WHERE hs.id =:idhoja")
                 ->setParameter('idhoja', $idhoja2); 
            $resultado = $query->getSingleResult();
            $titulo2=$resultado['titulo'];

            $nombreatraves   = $titulo2." ".$empleado2->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto();

        /* ********************* */

            $cargoatraves = $form->get('cargoatraves')->getData();
        }
        else{
            $nombreatraves = "";
            $cargoatraves  = "";
        }
       
        if ($form->isValid()) { //Formulario enlazado correctamente
            $em->persist($entity);
            $em->flush();
        }
        else{
            $this->get('session')->getFlashBag()->add('error', 'Se ha producido un error. Revise la información ingresada e intente nuevamente');
            return $this->render('ExpedienteBundle:Memorandum:new.html.twig', array(
            'entity'   => $entity,
            'form'     => $form->createView(),
            'tipomemo' => $tipomemo,
        ));
        }
     /* ****** Generar Reporte ****/

     // Incluimos camino de migas
    $breadcrumbs = $this->get("white_october_breadcrumbs");
    $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
    $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
    $breadcrumbs->addItem("Documentos", $this->get("router")->generate("pantalla_documentos"));
    $breadcrumbs->addItem("Elegir tipo memorándum", $this->get("router")->generate("memorandum"));
    $breadcrumbs->addItem("Nuevo memorándum", $this->get("router")->generate("memorandum_new",array('tipomemo'=>$tipomemo)));
    $breadcrumbs->addItem("Memorándum generado", "");


     // Nombre reporte
     $filename= 'Memorandum.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Memorandum/Memorandum/Memorandum.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("correlativo", new java("java.lang.String", $correlativo));
     $Parametro->put("empleado", new java("java.lang.String", $nombreempleado));
     $Parametro->put("atraves", new java("java.lang.String", $nombreatraves));
     $Parametro->put("cargo", new java("java.lang.String", $cargo));
     $Parametro->put("cargoatraves", new java("java.lang.String", $cargoatraves));
     $Parametro->put("asunto", new java("java.lang.String", $asunto));
     $Parametro->put("contenido", new java("java.lang.String", $contenido));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


   /* Función que genera el correlativo del memorándum a partir del ultimo generado */
   public function correlMemorandum(){
        $em = $this->getDoctrine()->getManager();
        
        //conocer correlativo
        $query = $em->createQuery("SELECT COUNT(m.correlativo) AS  correlativo 
        FROM ExpedienteBundle:Memorandum m 
        where  substring(m.correlativo,1,4) = :actual")
       ->setParameter('actual', date('Y'));

        $resultado = $query->getsingleResult();

        $num=$resultado['correlativo'];

        if($num==0){

            $correlativo= date('Y')."-001";
        }
        if($num > 0){
            $num++;
            $correlativo = date('Y')."-".str_pad($num, 3, "0", STR_PAD_LEFT);
        }
        return $correlativo;
    }

    public function cartaTrabajoAction()
    {
     $em = $this->getDoctrine()->getManager();

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idcontratacion  = $request->get('id'); 

     $contratacion = $em->getRepository('ExpedienteBundle:Contratacion')->find($idcontratacion);
     
     if($contratacion->getTipocontratacion()=='1'){
        $fechafin=$contratacion->getFechafinnom();
     }
     else{
        $fechafin=$contratacion->getFechafincontrato();
     }

     if ($fechafin == null){
        $fechafin = "";
     }
     else{
         $fechafin = date_format($fechafin, 'Y-m-d');
     }
 
     $idexp = $contratacion->getIdempleado()->getIdexpediente()->getId();


     
     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Documentos", $this->get("router")->generate("pantalla_documentos"));
     $breadcrumbs->addItem("Nueva constancia de trabajo", $this->get("router")->generate("carta_trabajo"));
     $breadcrumbs->addItem("Constancia de trabajo generada", $this->get("router")->generate("carta_trabajo"));

     
     // Nombre reporte
     $filename= 'Constancia trabajo.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Constancia/constanciadetrabajo.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idcontrato", new java("java.lang.Integer", $idcontratacion));
     $Parametro->put("idexp", new java("java.lang.Integer", $idexp));
     $Parametro->put("fechafin", new java("java.lang.String", $fechafin));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


   public function ReporteEvaluacionAction()
    {

     $em = $this->getDoctrine()->getManager();

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idevaluacion  = $request->get('idevaluacion'); 
     $calificacion  = $request->get('calificacion'); 

     $evaluacion = $em->getRepository('EvaluacionBundle:Evaluacion')->find($idevaluacion);

     //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$evaluacion->getPuestojefe())));
        $breadcrumbs->addItem("Resultados Evaluación", $this->get("router")->generate("evaluacion_show",array('id'=>$evaluacion->getId())));
        $breadcrumbs->addItem("Reporte de Evaluación", $this->get("router")->generate("hello_page"));
        //fin camino de miga

     if(count($evaluacion->getIncidentes()) == 0){
        $incidentes = 'N';
     }
     else{
        $incidentes = 'Y';
     }
          
     // Nombre reporte
     $filename= 'Evaluacion.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Evaluacionindividual/formulario_evaluacionxempleado.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("nevaluacion", new java("java.lang.Integer", $idevaluacion));
     $Parametro->put("cadena", new java("java.lang.String", $calificacion));
     $Parametro->put("incidentes", new java("java.lang.String", $incidentes));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }



   public function ReportePlanCapacitacionAction()
    {

     /* Obtengo parametros */
     $request=$this->getRequest();
     $anio  = $request->get('anio'); 

     // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
     $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
     $breadcrumbs->addItem("Consultar plan de capacitación",$this->get("router")->generate("plancapacitacion"));
     $breadcrumbs->addItem("Listado de capacitaciones",$this->get("router")->generate("plancapacitacion_show",array('id'=>$request->get('id'))));
     $breadcrumbs->addItem("Reporte","");
          
     // Nombre reporte
     $filename= 'Plan Capacitacion.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Capacitaciones/planinstitucional_impreso.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("ano", new java("java.lang.String", $anio));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


 }