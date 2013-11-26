<?php
namespace SIGESRHI\ReporteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JRU;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JdbcConnection;
use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
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

    public function indexAction()
    {
      
    	$em = $this->getDoctrine()->getManager();
  		$query = $em->createQuery('
          SELECT e.id idexp, s.nombres nombre FROM ExpedienteBundle:Solicitudempleo s
          join s.idexpediente e'
        );

        $expedientes = $query->getResult();

      // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Reportes", $this->get("router")->generate("reporte_prueba"));

    	return $this->render('ReporteBundle:Reportes:reportes.html.twig',array('expedientes'=>$expedientes));
	       
    }

    public function createAction()
    {

    //Incluimos camino de migas
      
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Reportes", $this->get("router")->generate("reporte_prueba"));
      $breadcrumbs->addItem("Hoja de servicio", $this->get("router")->generate("reporte_create"));

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idEmp=$request->get('idemp');           
     
     // Nombre reporte
     $filename= 'Hoja de servicio.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Hojadeservicio.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Parametro en caso de que el reporte no este parametrizado
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("idexp", new java("java.lang.Integer", $idEmp));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }



   public function ReporteSeguroVidaAction()
    {

  
     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('idexp');           

     //Incluimos camino de migas 
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida_consultar"));
     $breadcrumbs->addItem("Ver registro", $this->get("router")->generate("segurovida_show",array("id"=>$request->get('id'))));
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
     
    //Incluimos camino de migas 
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Solicitud de empleo", $this->get("router")->generate("solicitud_caspirante"));
     $breadcrumbs->addItem("Ver registro", $this->get("router")->generate("solicitud_show",array("id"=>$idSol)));
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

    //Incluimos camino de migas
      
      $breadcrumbs = $this->get("white_october_breadcrumbs");
      $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
      $breadcrumbs->addItem("Prueba psicólogica", $this->get("router")->generate("pruebapsicologica_index_edit"));
      $breadcrumbs->addItem("Reporte", $this->get("router")->generate("reporte_pruebapsicologica"));

     /* Obtengo parametros */
     $request=$this->getRequest();
     $idExp=$request->get('idexp');           
     
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

 }