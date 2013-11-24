<?php

namespace SIGESRHI\AdminBundle\Controller;

use SIGESRHI\AdminBundle\Entity\Usuario;
use SIGESRHI\AdminBundle\Entity\Rol;
use SIGESRHI\AdminBundle\Entity\Acceso;

use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));

        $session = $this->getRequest()->getSession();
        $session->set('seccion',0);

        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function cambiaopcionAction($acceso){

        //$foo = $session->get('seccion');
        $session = $this->getRequest()->getSession();
        $session->set('seccion',$acceso);

        /*
        $request=$this->container->get('request');
        $routename=$request->get('_route');
        */

        return $this->render('AdminBundle:Default:index.html.twig');
    }


    public function menuAction($nombreUsuario)
    {
  		$em = $this->getDoctrine()->getManager();
  		$query = $em->createQuery('
          SELECT u.id iduser, g.id idrol, a.nombrepagina pagina, a.ruta ruta, a.id acceso, IDENTITY(a.idaccesosup) padre, m.nombremodulo modulo,
          (SELECT COUNT(a2.id) FROM AdminBundle:Acceso a2 where a2.idaccesosup = a.id) hijos
          FROM ApplicationSonataUserBundle:User u
          join u.groups g
          join g.idacceso a
          join a.idmodulo m
          WHERE u.username = :username  and a.idaccesosup is null order by m.nombremodulo'
        )->setParameter('username', $nombreUsuario);  //and a.idaccesosup is null

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

    public function SeccionesAction($idacceso, $nombreUsuario)
    {
      $em = $this->getDoctrine()->getManager();
      //consulta de prueba recuperar los nombres de opciones
      $query = $em->createQuery('
        select a1.nombrepagina pagina_abuelo, (SELECT COUNT(a5.id) FROM AdminBundle:Acceso a5 where a5.idaccesosup = a1.id) hijos_abuelo,
                a2.nombrepagina pagina_padre, a2.ruta ruta_padre, (SELECT COUNT(a4.id) FROM AdminBundle:Acceso a4 where a4.idaccesosup = a2.id) hijos_padre,
                a3.nombrepagina pagina_hijo, a3.ruta ruta_hijo, m.nombremodulo modulo
                from ApplicationSonataUserBundle:User u
                join u.groups g
                join g.idacceso a1
                join a1.idmodulo m
                left join a1.idaccesohija a2 
                left join a2.idaccesohija a3
                WHERE a2.id in (select a7.id from ApplicationSonataUserBundle:User u2 join u2.groups g2 join g2.idacceso a7 where u2.username= :username)
                and (a3.id in (select a6.id from ApplicationSonataUserBundle:User u3 join u3.groups g3 join g3.idacceso a6 where u3.username= :username) or a3.id is null)
                and a1.id = :idacceso and u.username = :username
                ORDER BY a2.nombrepagina ASC'
          )->setParameter('idacceso', $idacceso)->setParameter('username', $nombreUsuario);

  
        $opciones = $query->getResult();
               
        return $this->render('::menuSecciones.html.twig',array('opciones'=>$opciones));
    
    }
}

