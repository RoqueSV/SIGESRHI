<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\Docnoticia;
use SIGESRHI\AdminBundle\Form\DocnoticiaType;

/**
 * Docnoticia controller.
 *
 */
class DocnoticiaController extends Controller
{
    /**
     * Lists all Docnoticia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Docnoticia')->findAll();

        return $this->render('AdminBundle:Docnoticia:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Docnoticia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Docnoticia();
        $form = $this->createForm(new DocnoticiaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docnoticia_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Docnoticia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Docnoticia entity.
     *
     */
    public function newAction()
    {
        $entity = new Docnoticia();
        $form   = $this->createForm(new DocnoticiaType(), $entity);

        return $this->render('AdminBundle:Docnoticia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Docnoticia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Docnoticia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docnoticia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Docnoticia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Docnoticia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Docnoticia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docnoticia entity.');
        }

        $editForm = $this->createForm(new DocnoticiaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Docnoticia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Docnoticia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Docnoticia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docnoticia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DocnoticiaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docnoticia_edit', array('id' => $id)));
        }

        return $this->render('AdminBundle:Docnoticia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Docnoticia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Docnoticia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Docnoticia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docnoticia'));
    }

    /**
     * Creates a form to delete a Docnoticia entity by id.
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
