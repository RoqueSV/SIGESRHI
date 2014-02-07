<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Opcion;
use SIGESRHI\EvaluacionBundle\Form\OpcionType;

/**
 * Opcion controller.
 *
 */
class OpcionController extends Controller
{
    /**
     * Lists all Opcion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvaluacionBundle:Opcion')->findAll();

        return $this->render('EvaluacionBundle:Opcion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Opcion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Opcion();
        $form = $this->createForm(new OpcionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('opcion_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Opcion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Opcion entity.
     *
     */
    public function newAction()
    {
        $entity = new Opcion();
        $form   = $this->createForm(new OpcionType(), $entity);

        return $this->render('EvaluacionBundle:Opcion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Opcion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Opcion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Opcion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
        }

        $editForm = $this->createForm(new OpcionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Opcion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Opcion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Opcion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Opcion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OpcionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('opcion_edit', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Opcion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Opcion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Opcion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Opcion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('opcion'));
    }

    /**
     * Creates a form to delete a Opcion entity by id.
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
