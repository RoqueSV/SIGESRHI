<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Form\FactorevaluacionType;

/**
 * Factorevaluacion controller.
 *
 */
class FactorevaluacionController extends Controller
{
    /**
     * Lists all Factorevaluacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvaluacionBundle:Factorevaluacion')->findAll();

        return $this->render('EvaluacionBundle:Factorevaluacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Factorevaluacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Factorevaluacion();
        $form = $this->createForm(new FactorevaluacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('factorevaluacion_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Factorevaluacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Factorevaluacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Factorevaluacion();
        $form   = $this->createForm(new FactorevaluacionType(), $entity);

        return $this->render('EvaluacionBundle:Factorevaluacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Factorevaluacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Factorevaluacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Factorevaluacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

        $editForm = $this->createForm(new FactorevaluacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Factorevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Factorevaluacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FactorevaluacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('factorevaluacion_edit', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Factorevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Factorevaluacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('factorevaluacion'));
    }

    /**
     * Creates a form to delete a Factorevaluacion entity by id.
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
