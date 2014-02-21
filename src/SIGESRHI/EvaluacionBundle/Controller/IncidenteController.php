<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Incidente;
use SIGESRHI\EvaluacionBundle\Form\IncidenteType;

/**
 * Incidente controller.
 *
 */
class IncidenteController extends Controller
{
    /**
     * Lists all Incidente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvaluacionBundle:Incidente')->findAll();

        return $this->render('EvaluacionBundle:Incidente:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Incidente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Incidente();
        $form = $this->createForm(new IncidenteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('incidente_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Incidente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Incidente entity.
     *
     */
    public function newAction()
    {
        $entity = new Incidente();
        $form   = $this->createForm(new IncidenteType(), $entity);

        return $this->render('EvaluacionBundle:Incidente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Incidente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Incidente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incidente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Incidente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Incidente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Incidente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incidente entity.');
        }

        $editForm = $this->createForm(new IncidenteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Incidente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Incidente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Incidente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incidente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new IncidenteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('incidente_edit', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Incidente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Incidente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Incidente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Incidente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('incidente'));
    }

    /**
     * Creates a form to delete a Incidente entity by id.
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
