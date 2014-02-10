<?php
namespace SIGESRHI\ReporteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JRU;
use SIGESRHI\ReporteBundle\Resources\PHPJRU\JdbcConnection;
use SIGESRHI\ReporteBundle\Controller\DefaultController;
use \Java;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

class ModuloReporteController extends Controller
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

/********** Reporte de aspirantes x plaza. Filtro: plaza y según fecha *********/
  public function plazaAspiranteAction(){
        $source = new Entity('AdminBundle:Plaza','grupo_plaza_reporte');
        
        $grid = $this->get('grid');
       

        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if(strlen($row->getField('misionplaza')) >= 120 ){
                   $row->setField('misionplaza', substr($row->getField('misionplaza'),0,120)." ...");          
                }//if
                return $row;
            }
        );

        $grid->setId('grid_reporteplaza');
        $grid->setSource($source);              
        
    
        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'reporte_aspirante_seleccionar');
        $grid->addRowAction($rowAction1);
        

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
        $breadcrumbs->addItem("Aspirantes / Seleccionar plaza", "");
        
        return $grid->getGridResponse('ReporteBundle:Reportes:plaza_aspirante.html.twig');
  }

  public function seleccionarReporteAction()
    {
        $request = $this->getRequest();
        $idplaza = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $plaza = $em->getRepository('AdminBundle:Plaza')->find($idplaza);

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
        $breadcrumbs->addItem("Aspirantes / Seleccionar plaza", $this->get("router")->generate("reporte_aspirante_plaza"));
        $breadcrumbs->addItem("Selección de reporte", $this->get("router")->generate("reporte_aspirante_plaza"));
        
        return $this->render('ReporteBundle:Reportes:reporte_aspirantes.html.twig', array(
            'idplaza'      => $idplaza,
            'entity'       => $plaza,
        ));
    }

    public function ReporteAspiranteAction()
    {

     /* Obtengo parametros */
     $request = $this->getRequest();
     $idplaza = $request->get('idplaza'); 
     $tipo_reporte = $request->get('tipo_reporte');
     $fechainicio = $request->get('fechainicio');
     $fechafin = $request->get('fechafin'); 

     if($tipo_reporte == 1){
     	$cadena = "";
     }    
     else{
     	$cadena = " and fechaexpediente between '".$fechainicio."' and '".$fechafin."' ";
     }


     // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
     $breadcrumbs->addItem("Seleccionar plaza", $this->get("router")->generate("reporte_aspirante_plaza"));
     $breadcrumbs->addItem("Selección de reporte", $this->get("router")->generate("reporte_aspirante_seleccionar",array('id'=>$idplaza)));
     $breadcrumbs->addItem("Reporte", "");
     
     // Nombre reporte
     $filename= 'Reporte aspirantes.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Estadisticos/Reporte_expedientes_aspirantes.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("id_plaza", new java("java.lang.Integer", $idplaza));
     $Parametro->put("cadena", new java("java.lang.String", $cadena));
     $Parametro->put("fechainicio", new java("java.lang.String", $fechainicio));
     $Parametro->put("fechafin", new java("java.lang.String", $fechafin));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function seleccionarReporteEmpleadoAction()
    {
     
     $em = $this->getDoctrine()->getManager();
     $centros = $em->getRepository('AdminBundle:Centrounidad')->findAll();

     // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
     $breadcrumbs->addItem("Expediente de empleados", $this->get("router")->generate("reporte_empleado_seleccionar"));
        
     return $this->render('ReporteBundle:Reportes:reporte_empleado.html.twig',array('centros'=>$centros));
    }

    public function ReporteEmpleadosAntiguedadAction()
    {

     /* Obtengo parametros */
     $request = $this->getRequest();
     $anios = $request->get('anios'); 

     //Comprobar existencia de registros
      $em = $this->getDoctrine()->getManager();
      $empleados = $em->getRepository('ExpedienteBundle:Hojaservicio')->findAll();

      $cuenta = 0;
      $antiguedad = date("Y-m-d", strtotime(date('Y-m-d') ."-".$anios." year"));  
      $fecha_antiguo = new \Datetime($antiguedad);

      foreach ($empleados as $empleado) {
           if($empleado->getFechaingreso() <= $fecha_antiguo)
           $cuenta++;
      }

      if($cuenta == 0){
      	$this->get('session')->getFlashBag()->add('error', 'No existen registros para la cantidad de años ingresada');

        return $this->redirect($this->generateUrl('reporte_empleado_seleccionar'));
      }

      /* ********* */
     
      // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
     $breadcrumbs->addItem("Expediente de empleados", $this->get("router")->generate("reporte_empleado_seleccionar"));
     $breadcrumbs->addItem("Reporte", "");
     
     // Nombre reporte
     $filename= 'Reporte empleadosantiguos.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Estadisticos/reporte_empleadosantiguos.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("años", new java("java.lang.Integer", $anios));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }

   public function ReporteEmpleadosDoblePlazaAction()
    {
         
      // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
     $breadcrumbs->addItem("Expediente de empleados", $this->get("router")->generate("reporte_empleado_seleccionar"));
     $breadcrumbs->addItem("Reporte", "");
     
     // Nombre reporte
     $filename= 'Reporte empleadosdobleplaza.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Estadisticos/reporte_empleadoscondobleplaza.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }


   public function ReporteEmpleadosCentroAction()
    {

     /* Obtengo parametros */
     $request = $this->getRequest();
     $idcentro = $request->get('idcentro');

     //Comprobar existencia de registros
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("SELECT COUNT(r.idempleado) AS  numempleados 
                                 FROM AdminBundle:Centrounidad c 
                                 JOIN c.idunidad u
                                 JOIN u.idrefrenda r
                                 where c.id = :idcentro")
                   ->setParameter('idcentro',$idcentro);

      $resultado = $query->getsingleResult();
      $numempleados = $resultado['numempleados'];

      if($numempleados == 0){
        $this->get('session')->getFlashBag()->add('error', 'No existen empleados en el centro seleccionado');

        return $this->redirect($this->generateUrl('reporte_empleado_seleccionar'));
      }

      /* ************************ */
         
      // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
     $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
     $breadcrumbs->addItem("Expediente de empleados", $this->get("router")->generate("reporte_empleado_seleccionar"));
     $breadcrumbs->addItem("Reporte", "");
     
     // Nombre reporte
     $filename= 'Reporte empleadosxcentro.pdf';
     
     //Llamando la funcion JRU de la libreria php-jru
     $jru=new JRU();
     //Ruta del reporte compilado Jasper generado por IReports
     $Reporte=__DIR__.'/../Resources/reportes/Estadisticos/reporte_empleadoxcentro.jasper';
     //Ruta a donde deseo Guardar mi archivo de salida Pdf
     $SalidaReporte=__DIR__.'/../../../../web/uploads/reportes/'.$filename;
     //Paso los parametros necesarios
     $Parametro=new java('java.util.HashMap');
     $Parametro->put("id_centro", new java("java.lang.Integer", $idcentro));
     $Parametro->put("ubicacionReport", new java("java.lang.String", __DIR__));
     //Funcion de Conexion a Base de datos 
     $Conexion = $this->crearConexion();
     //Generamos la Exportacion del reporte
     $jru->runReportToPdfFile($Reporte,$SalidaReporte,$Parametro,$Conexion->getConnection());
     
     return $this->render('ReporteBundle:Reportes:vistapdf.html.twig',array('reportes'=>$filename));
   }




}