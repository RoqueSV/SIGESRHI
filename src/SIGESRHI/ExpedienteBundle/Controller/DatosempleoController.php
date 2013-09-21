<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Datosempleo;
use SIGESRHI\ExpedienteBundle\Form\DatosempleoType;

/**
 * Datosempleo controller.
 *
 */
class DatosempleoController extends Controller
{
    /**
     * Lists all Datosempleo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Datosempleo')->findAll();

        return $this->render('ExpedienteBundle:Datosempleo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Datosempleo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Datosempleo();
        $form = $this->createForm(new DatosempleoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosempleo_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Datosempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Datosempleo entity.
     *
     */
    public function newAction()
    {
        $entity = new Datosempleo();
        $form   = $this->createForm(new DatosempleoType(), $entity);

        return $this->render('ExpedienteBundle:Datosempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Datosempleo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosempleo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Datosempleo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Datosempleo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosempleo entity.');
        }

        $editForm = $this->createForm(new DatosempleoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Datosempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Datosempleo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosempleo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DatosempleoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosempleo_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Datosempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Datosempleo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Datosempleo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Datosempleo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosempleo'));
    }

    /**
     * Creates a form to delete a Datosempleo entity by id.
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
