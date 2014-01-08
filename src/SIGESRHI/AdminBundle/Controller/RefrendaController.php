<?php

namespace SIGESRHI\AdminBundle\Controller;

use Doctrine\ORM\EntityRepository;

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
      $archivo = $this->get('request')->request->get('arch_refrenda');
      //$_FILES

      return $this->render('AdminBundle:Refrenda:cargar.html.twig');
    }

   
}

