<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PantallasController extends Controller
{
       public function pantallaModuloAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
          SELECT a.id acceso, a.nombrepagina pagina, a.ruta ruta  FROM AdminBundle:Acceso a  
          join a.idmodulo m 
          WHERE m.id = :id and a.idaccesosup is null order by a.id'
        )->setParameter('id', $id);

        $opciones = $query->getResult(); 

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        if($id==1){
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>$id)));
        return $this->render('AdminBundle:Pantallas:pantalla_expediente.html.twig',array('opciones'=>$opciones));

       }

       if($id==2){
        $breadcrumbs->addItem("Promocion de Personal", $this->get("router")->generate("pantalla_modulo",array('id'=>$id)));
        return $this->render('AdminBundle:Pantallas:pantalla_promocion.html.twig',array('opciones'=>$opciones));
        
       }


       if($id==3){
        $breadcrumbs->addItem("Capacitación Institucional", $this->get("router")->generate("pantalla_modulo",array('id'=>$id)));
        return $this->render('AdminBundle:Pantallas:pantalla_capacitacion.html.twig',array('opciones'=>$opciones));
        
       }

        if($id==4){
        $breadcrumbs->addItem("Evaluación de Desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>$id)));
        return $this->render('AdminBundle:Pantallas:pantalla_evaluacion.html.twig',array('opciones'=>$opciones));
       }

        if($id==5){
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>$id)));
        return $this->render('AdminBundle:Pantallas:pantalla_generareportes.html.twig',array('opciones'=>$opciones));
       }
    }

    public function pantallaAspiranteAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        return $this->render('AdminBundle:Pantallas:pantalla_hexpediente.html.twig');
    }

    public function pantallaEmpleadoActivoAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        return $this->render('AdminBundle:Pantallas:pantalla_hexpediente.html.twig');
    }

    public function pantallaEmpleadoInactivoAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        return $this->render('AdminBundle:Pantallas:pantalla_hexpediente.html.twig');
    }



    public function pantallaCapacitacionesAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitación Institucional", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        return $this->render('AdminBundle:Pantallas:pantalla_hcapacitacion.html.twig');
    }


 public function pantallaInstitucionesAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitación Institucional", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Instituciones", $this->get("router")->generate("pantalla_instituciones"));
        return $this->render('AdminBundle:Pantallas:pantalla_hcapacitacion.html.twig');
    }

 public function pantallaFacilitadoresAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitación Institucional", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
        return $this->render('AdminBundle:Pantallas:pantalla_hcapacitacion.html.twig');
    }

public function pantallaDocumentosAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Documentos", $this->get("router")->generate("pantalla_documentos"));
        return $this->render('AdminBundle:Pantallas:pantalla_hreportes.html.twig');
    }

public function pantallaReportesAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Reportes", $this->get("router")->generate("pantalla_reportes"));
        return $this->render('AdminBundle:Pantallas:pantalla_hreportes.html.twig');
    }

public function pantallaRealizarEvaluacionAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de Desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("pantalla_evaluacion"));
        return $this->render('AdminBundle:Pantallas:pantalla_hevaluacion.html.twig');
    }

public function pantallaFormulariosEvaluacionAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de Desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("pantalla_formularios"));
        return $this->render('AdminBundle:Pantallas:pantalla_hevaluacion.html.twig');
    }


}