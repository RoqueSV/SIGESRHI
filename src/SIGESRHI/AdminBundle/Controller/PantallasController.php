<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PantallasController extends Controller
{
    public function pantallaExpedienteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
          SELECT a.id acceso, a.nombrepagina pagina, a.ruta ruta  FROM AdminBundle:Acceso a  
          join a.idmodulo m 
          WHERE m.id = :id and a.idaccesosup is null order by a.nombrepagina'
        )->setParameter('id', 1);

        $opciones = $query->getResult(); 


        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_expediente"));
        return $this->render('AdminBundle:Pantallas:pantalla_expediente.html.twig',array('opciones'=>$opciones));
    }

    public function pantallaAspiranteAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_expediente"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        return $this->render('AdminBundle:Pantallas:pantalla_aspirante.html.twig');
    }

    public function pantallaEmpleadoActivoAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_expediente"));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        return $this->render('AdminBundle:Pantallas:pantalla_empleadoactivo.html.twig');
    }

    public function pantallaEmpleadoInactivoAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_expediente"));
        $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        return $this->render('AdminBundle:Pantallas:pantalla_empleadoinactivo.html.twig');
    }
}