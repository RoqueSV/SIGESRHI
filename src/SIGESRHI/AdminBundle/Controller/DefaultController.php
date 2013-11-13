<?php

namespace SIGESRHI\AdminBundle\Controller;

use SIGESRHI\AdminBundle\Entity\Usuario;
use SIGESRHI\AdminBundle\Entity\Rol;
use SIGESRHI\AdminBundle\Entity\Acceso;
//use SIGESRHI\AdminBundle\Entity\Modulo;

use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("sonata_user_impersonating"));
        return $this->render('AdminBundle:Default:index.html.twig');
    }


    public function menuAction($nombreUsuario)
    {
  		$em = $this->getDoctrine()->getManager();
  		$query = $em->createQuery('
          SELECT u.id iduser, g.id idrol, a.nombrepagina pagina, a.ruta ruta, m.nombremodulo modulo FROM ApplicationSonataUserBundle:User u
          join u.groups g
          join g.idacceso a
          join a.idmodulo m
          WHERE u.username = :username order by m.nombremodulo'
        )->setParameter('username', $nombreUsuario);

        $opciones = $query->getResult();

        return $this->render('::menuBase.html.twig',array('opciones'=>$opciones));
    
    }

    public function rolAction($nombreUsuario)
    {
     $em = $this->getDoctrine()->getManager();
     $query = $em->createQuery('
          SELECT g.id rol FROM ApplicationSonataUserBundle:User u
          join u.groups g
          WHERE u.username = :username'
        )->setParameter('username', $nombreUsuario);
        try {
        $id = $query->getSingleResult(); 
        }
        catch(\Doctrine\ORM\NoResultException $e) {
        $id=null;
        }
        $rol = $em->getRepository('ApplicationSonataUserBundle:Group')->findOneById($id);

        return new Response($rol);
    }
}

