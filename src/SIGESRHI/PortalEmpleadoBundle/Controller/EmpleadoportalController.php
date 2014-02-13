<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;

use Doctrine\ORM\EntityRepository;

/**
 * Empleado controller.
 *
 */
class EmpleadoportalController extends Controller
{
    /**
     * Vista de informacion del Empleado
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        if($user == 'anon.'){
			return $this->redirect($this->generateUrl('hello_page'));        	
        }
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();

        $entity = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
        }
        //obtenemos las plazas del empleado
        $query = $em -> createQuery("SELECT r.nombreplaza, r.sueldoactual FROM ExpedienteBundle:Empleado e JOIN e.idrefrenda r WHERE e.id=:idempleado")
                    ->setParameter('idempleado',$idempleado);
        $plazas = $query->getResult();
        
        //obtenemos los datos de estudio
        $query2 = $em -> createQuery("SELECT de.centroestudio, t.niveltitulo, t.nombretitulo  FROM ExpedienteBundle:Empleado e JOIN e.idexpediente ex JOIN ex.idsolicitudempleo s JOIN s.Destudios de  JOIN de.idtitulo t WHERE e.id=:idempleado ORDER BY t.niveltitulo ASC")
                    ->setParameter('idempleado',$idempleado);
        $Destudios = $query2->getResult();
        
        //obtenemos los idiomas del empleado
        $query3 = $em -> createQuery("SELECT i.nombreidioma, i.nivelhabla, i.nivelescribe, i.nivellee FROM ExpedienteBundle:Empleado e JOIN e.idexpediente ex JOIN ex.idsolicitudempleo s JOIN s.Idiomas i WHERE e.id=:idempleado ")
                    ->setParameter('idempleado',$idempleado);
        $idiomas = $query3->getResult();

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Informacion Personal", "");
        return $this->render('SIGESRHIPortalEmpleadoBundle:Empleadoportal:show.html.twig', array(
            'entity'    => $entity,
            'plazas'    => $plazas,
            'Destudios' => $Destudios,
            'idiomas'   => $idiomas,
        ));
    }

}
