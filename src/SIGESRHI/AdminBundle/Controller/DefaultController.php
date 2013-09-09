<?php

namespace SIGESRHI\AdminBundle\Controller;

use SIGESRHI\AdminBundle\Entity\Usuario;
use SIGESRHI\AdminBundle\Entity\Rol;
use SIGESRHI\AdminBundle\Entity\Acceso;
//use SIGESRHI\AdminBundle\Entity\Modulo;

use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }


    public function menuAction($nombreUsuario)
    {
  		$em = $this->getDoctrine()->getManager();
  		$query = $em->createQuery('
          SELECT u.id iduser, r.id idrol, a.nombrepagina pagina, a.ruta ruta, m.nombremodulo modulo FROM AdminBundle:Usuario u
          join u.idrol r
          join r.idacceso a
          join a.idmodulo m
		      WHERE u.username = :username order by m.nombremodulo'
        )->setParameter('username', $nombreUsuario);

        $opciones = $query->getResult();
               
        return $this->render('::menuBase.html.twig',array('opciones'=>$opciones));
    
    }
}
