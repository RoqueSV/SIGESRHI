<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Java;
use \JavaClass;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ExpedienteBundle:Default:index.html.twig', array('name' => $name));
    }
	public function crearConexion() {
        $memo = new Java('org.postgresql.Driver');
        $drm = new JavaClass("java.sql.DriverManager");
        $host = $this->container->getParameter('database_host');
        $userdb = $this->container->getParameter('database_user');
        $password = $this->container->getParameter('database_password');
        $port = $this->container->getParameter('database_port');
        $db = $this->container->getParameter('database_name');
        $Conn = $drm->getConnection("jdbc:postgresql://" . $host . ":" . $port . "/" . $db, $userdb, $password);
        return $Conn;
    }
	public function reportePruebaAction() {
        // $request = $this->getRequest();
        // $id = $request->get('id');
        // $trimestre=$request->get('trimestre');
        // $idDepen=$request->get('idUniOrg');
        // $anio = $request->get('anio');
        // $unidadDao = new UnidadOrganizativaDao($this->getDoctrine());
        // $unidadOrg = new UnidadOrganizativa();
        // $unidadOrg = $unidadDao->getUnidadOrg($idDepen);
        
        // if ($trimestre==1) {
            // $mes ='Enero';
        // } elseif ($trimestre==2) {
            // $mes ='Febrero';
        // }elseif ($trimestre==3) {
            // $mes ='Marzo';
        // }elseif ($trimestre==4) {
            // $mes ='Abril';
        // }elseif ($trimestre==5) {
            // $mes ='Mayo';
        // }elseif ($trimestre==6) {
            // $mes ='Junio';
        // }elseif ($trimestre==7) {
            // $mes ='Julio';
        // }elseif ($trimestre==8) {
            // $mes ='Agosto';
        // }elseif ($trimestre==9) {
            // $mes ='Septiembre';
        // }elseif ($trimestre==10) {
            // $mes ='Octubre';
        // }elseif ($trimestre==11) {
            // $mes ='Noviembre';
        // }elseif ($trimestre==12) {
            // $mes ='Diciembre';
        // }
		
        
        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/reportes/Prueba.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            // if(isset($idDepen)){
                // $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                // $paoSegumiento = new Pao();
                // $paoSegumiento = $unidaDao->getPaoSeguimiento($idDepen);
                // $id=$paoSegumiento->getProgramacionMonitoreo()->getIdPrograMon();
                
            // }
            // $params->put("idPrograMonit", new java("java.lang.Integer", $id));
            // $params->put("trim", new java("java.lang.Integer", $trimestre));
            // $params->put("idDepen", new java("java.lang.Integer", $idDepen));
            // $params->put("ve_anio", new java("java.lang.Integer", $anio));
            // $params->put("mes", new java("java.lang.String",$mes));
            // $params->put("ubicacionReport", new java("java.lang.String", __DIR__));
            // $params->put("NombreUnidad", new java("java.lang.String", $unidadOrg->getNombreUnidad()));
            $Conn = $this->crearConexion();

            $jasperPrint = $fillManager->fillReport($report, $params, $Conn);
            $outputPath = realpath(".") . "/" . "output.pdf";

            $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);

            header("Content-type: application/pdf");
            readfile($outputPath);
            //unlink($outputPath);
            $Conn->close();

            $this->getResponse()->clearHttpHeaders();
            $this->getResponse()->setHttpHeader('Pragma: public', true);
            $this->getResponse()->setContentType('application/pdf');
            $this->getResponse()->sendHttpHeaders();
        } catch (Exception $ex) {
            print $ex->getCause();
            if ($Conn != null) {
                $Conn->close();
            }
            throw $ex;
        }

        return $this->getResponse();
    }
}
