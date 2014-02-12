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

        return $this->render('SIGESRHIPortalEmpleadoBundle:Empleadoportal:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

}
