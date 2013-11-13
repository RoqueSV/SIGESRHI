<?php

namespace SIGESRHI\ReporteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ReporteBundle:Default:index.html.twig', array('name' => $name));
    }
}
