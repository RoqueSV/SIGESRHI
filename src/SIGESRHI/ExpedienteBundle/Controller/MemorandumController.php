<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Memorandum;
use SIGESRHI\ExpedienteBundle\Form\MemorandumType;

/**
 * Memorandum controller.
 *
 */
class MemorandumController extends Controller
{
    /**
     * Lists all Memorandum entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Memorandum')->findAll();

        return $this->render('ExpedienteBundle:Memorandum:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Memorandum entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Memorandum();
        $form = $this->createForm(new MemorandumType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('memorandum_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Memorandum:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Memorandum entity.
     *
     */
    public function newAction()
    {
        $entity = new Memorandum();
        $form   = $this->createForm(new MemorandumType(), $entity);

        return $this->render('ExpedienteBundle:Memorandum:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Memorandum entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Memorandum:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Memorandum entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $editForm = $this->createForm(new MemorandumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Memorandum:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Memorandum entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MemorandumType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('memorandum_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Memorandum:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Memorandum entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Memorandum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('memorandum'));
    }

    /**
     * Creates a form to delete a Memorandum entity by id.
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
