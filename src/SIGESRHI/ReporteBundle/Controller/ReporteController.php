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

 }