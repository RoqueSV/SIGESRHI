<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Tipoaccion;
use SIGESRHI\ExpedienteBundle\Form\TipoaccionType;

/**
 * Tipoaccion controller.
 *
 */
class TipoaccionController extends Controller
{
    /**
     * Lists all Tipoaccion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Tipoaccion')->findAll();

        return $this->render('ExpedienteBundle:Tipoaccion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Tipoaccion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Tipoaccion();
        $form = $this->createForm(new TipoaccionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipoaccion_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Tipoaccion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Tipoaccion entity.
     *
     */
    public function newAction()
    {
        $entity = new Tipoaccion();
        $form   = $this->createForm(new TipoaccionType(), $entity);

        return $this->render('ExpedienteBundle:Tipoaccion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipoaccion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Tipoaccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipoaccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Tipoaccion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Tipoaccion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Tipoaccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipoaccion entity.');
        }

        $editForm = $this->createForm(new TipoaccionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Tipoaccion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Tipoaccion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Tipoaccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipoaccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TipoaccionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipoaccion_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Tipoaccion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipoaccion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Tipoaccion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tipoaccion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipoaccion'));
    }

    /**
     * Creates a form to delete a Tipoaccion entity by id.
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
