<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CapacitacionBundle:Default:index.html.twig', array('name' => $name));
    }
}
