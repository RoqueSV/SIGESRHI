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
        select a1.nombrepagina hijo, 
                a2.nombrepagina padre, 
                a3.nombrepagina abuelo
                from AdminBundle:Acceso a1 
                left join a1.idaccesosup a2 
                left join a2.idaccesosup a3 
                ');

   /*   $query = $em->createQuery('
          SELECT a1.nombrepagina pagina_padre, a2.nombrepagina pagina, a2.ruta ruta, 
          (SELECT COUNT(a4.id) from AdminBundle:Acceso a4 where a4.idaccesosup = a2.id) numhijos,
          a3.nombrepagina pagina_nieto, a3.ruta ruta_nieto, m.nombremodulo modulo
          From ApplicationSonataUserBundle:User u
          join u.groups g
          join g.idacceso a1 
          join a1.idmodulo m
          left join a1.idaccesosup a2 with a1.id=a2.idaccesosup
          left join a2.idaccesosup a3 with a2.id=a3.idaccesosup
          WHERE a3.id = :idacceso and u.username = :username'
          )->setParameter('idacceso', $idacceso)->setParameter('username', $nombreUsuario);
  */
        $opciones = $query->getResult();
               
        return $this->render('::menuSecciones.html.twig',array('opciones'=>$opciones));
    
    }
}

/* trabajada

select a1.nombrepagina Padre, a2.nombrepagina Hijo, (select count(a4.id) from acceso a4 where a4.idaccesosup=a2.id) hijos, a3.nombrepagina Nieto
from acceso a1 left 
join acceso a2 on (a1.id=a2.idaccesosup) 
left join acceso a3 on (a2.id=a3.idaccesosup) 
where a1.id=1
group by a1.nombrepagina, a2.id,a2.nombrepagina, a3.nombrepagina; 


SELECT a1.nombrepagina pagina_padre, a2.nombrepagina pagina, a2.ruta ruta, 
          (SELECT COUNT(a4.id) from AdminBundle:Acceso a4 where a4.idaccesosup = a2.id) numhijos,
          a3.nombrepagina pagina_nieto, a3.ruta ruta_nieto, m.nombremodulo modulo
          From ApplicationSonataUserBundle:User u
          join u.groups g
          join g.idacceso a1 
          join a1.idmodulo m
          left join a1.idaccesosup a2
          left join a2.idaccesosup a3
          WHERE a1.id = :idacceso and u.username = :username order by m.nombremodulo'
         
*/