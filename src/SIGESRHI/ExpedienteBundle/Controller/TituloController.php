<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Titulo;
use SIGESRHI\ExpedienteBundle\Form\TituloType;

/**
 * Titulo controller.
 *
 */
class TituloController extends Controller
{
    /**
     * Lists all Titulo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Titulo')->findAll();

        return $this->render('ExpedienteBundle:Titulo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Titulo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Titulo();
        $form = $this->createForm(new TituloType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('titulo_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Titulo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Titulo entity.
     *
     */
    public function newAction()
    {
        $entity = new Titulo();
        $form   = $this->createForm(new TituloType(), $entity);

        return $this->render('ExpedienteBundle:Titulo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Titulo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Titulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titulo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Titulo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Titulo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Titulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titulo entity.');
        }

        $editForm = $this->createForm(new TituloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Titulo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Titulo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Titulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Titulo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TituloType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('titulo_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Titulo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Titulo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Titulo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Titulo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('titulo'));
    }

    /**
     * Creates a form to delete a Titulo entity by id.
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
