<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SIGESRHIPortalEmpleadoBundle:Default:index.html.twig', array('name' => $name));
    }
}
