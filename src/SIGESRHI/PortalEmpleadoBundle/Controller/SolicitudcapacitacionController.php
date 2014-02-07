<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\PortalEmpleadoBundle\Entity\Solicitudcapacitacion;
use SIGESRHI\PortalEmpleadoBundle\Form\SolicitudcapacitacionType;

/**
 * Solicitudcapacitacion controller.
 *
 */
class SolicitudcapacitacionController extends Controller
{
    /**
     * Lists all Solicitudcapacitacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->findAll();

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Solicitudcapacitacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Solicitudcapacitacion();
        $form = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitudcapacitacion_show', array('id' => $entity->getId())));
        }

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Solicitudcapacitacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Solicitudcapacitacion();
        $form   = $this->createForm(new SolicitudcapacitacionType(), $entity);

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Solicitudcapacitacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Solicitudcapacitacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $editForm = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Solicitudcapacitacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitudcapacitacion_edit', array('id' => $id)));
        }

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Solicitudcapacitacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitudcapacitacion'));
    }

    /**
     * Creates a form to delete a Solicitudcapacitacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
