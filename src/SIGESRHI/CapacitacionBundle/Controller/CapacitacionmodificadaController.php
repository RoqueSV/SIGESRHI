<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada;
use SIGESRHI\CapacitacionBundle\Form\CapacitacionmodificadaType;

/**
 * Capacitacionmodificada controller.
 *
 */
class CapacitacionmodificadaController extends Controller
{
    /**
     * Lists all Capacitacionmodificada entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CapacitacionBundle:Capacitacionmodificada')->findAll();

        return $this->render('CapacitacionBundle:Capacitacionmodificada:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Capacitacionmodificada entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /* Capacitacion original */
        $idcapacitacion = $request->get('idcap');
        $capacitacion = $em->getRepository('CapacitacionBundle:Capacitacion')->find($idcapacitacion);
        $capacitacion->setEstadocapacitacion($request->get('tipomod'));

        /* *****           ***** */

        $entity  = new Capacitacionmodificada();
        $entity->setIdcapacitacion($capacitacion);
        $form = $this->createForm(new CapacitacionmodificadaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('capacitacionmodificada_show', array('id' => $entity->getId())));
        }

        return $this->render('CapacitacionBundle:Capacitacionmodificada:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Capacitacionmodificada entity.
     *
     */
    public function newAction()
    {
        $entity = new Capacitacionmodificada();
        $form   = $this->createForm(new CapacitacionmodificadaType(), $entity);

        return $this->render('CapacitacionBundle:Capacitacionmodificada:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Capacitacionmodificada entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacionmodificada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacionmodificada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Capacitacionmodificada:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Capacitacionmodificada entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacionmodificada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacionmodificada entity.');
        }

        $editForm = $this->createForm(new CapacitacionmodificadaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Capacitacionmodificada:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Capacitacionmodificada entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacionmodificada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacionmodificada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CapacitacionmodificadaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('capacitacionmodificada_edit', array('id' => $id)));
        }

        return $this->render('CapacitacionBundle:Capacitacionmodificada:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Capacitacionmodificada entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CapacitacionBundle:Capacitacionmodificada')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Capacitacionmodificada entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('capacitacionmodificada'));
    }

    /**
     * Creates a form to delete a Capacitacionmodificada entity by id.
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
