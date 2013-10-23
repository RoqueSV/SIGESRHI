<?php
namespace SIGESRHI\ReporteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JRU;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JdbcConnection;
use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
use \Java;


class ReporteController extends Controller
{
    public function indexAction()
    {

    	$em = $this->getDoctrine()->getManager();
  		$query = $em->createQuery('
          SELECT e.id idexp, s.nombres nombre FROM ExpedienteBundle:Solicitudempleo s
          join s.idexpediente e'
        );

        $expedientes = $query->getResult();

    	return $this->render('ReporteBundle:Reportes:reportes.html.twig',array('expedientes'=>$expedientes));
	       
    }

    public function createAction()
    {
     /* Obtengo parametros */
     $request=$this->getRequest();
     $idEmp=$request->get('idemp');           
     

    $filename= uniqid().'.pdf';
		
	//Llamando la funcion JRU de la libreria php-jru
	$jru=new JRU();
	//Ruta del reporte compilado Jasper generado por IReports
	$Reporte=__DIR__.'/../Resources/reportes/Hojadeservicio.jasper';
	//Ruta a donde deseo Guardar Mi archivo de salida Pdf
	$SalidaReporte=__DIR__.'/../Resources/reportes/'.$filename;
	//Parametro en caso de que el reporte no este parametrizado
	$Parametro=new java('java.util.HashMap');
	$Parametro->put("idemp", new java("java.lang.Integer", $idEmp));
	//Funcion de Conexion a Base de datos 
	$Conexion= new	JdbcConnection("org.postgresql.Driver","jdbc:postgresql://localhost:5432/SIGESRHI","postgres","roquet87");
	//Generamos la Exportacion del reporte
	$jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
	
	if(file_exists($SalidaReporte)) 
	{ 	
		
     		$buffer = file_get_contents($SalidaReporte);
		
			unlink($SalidaReporte);
			header("Content-type: application/pdf");
            print $buffer;
	        die(0);
            $this->getResponse()->clearHttpHeaders();
            $this->getResponse()->setHttpHeader('Pragma: public', true);
            $this->getResponse()->setContentType('application/pdf');
            $this->getResponse()->sendHttpHeaders();
		    
	}
	return $this->getResponse();
   }

 }