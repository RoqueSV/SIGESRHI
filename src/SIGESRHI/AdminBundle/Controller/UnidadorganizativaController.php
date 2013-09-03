<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\Unidadorganizativa;
use SIGESRHI\AdminBundle\Form\UnidadorganizativaType;

/**
 * Unidadorganizativa controller.
 *
 */
class UnidadorganizativaController extends Controller
{
    /**
     * Lists all Unidadorganizativa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Unidadorganizativa')->findAll();

        return $this->render('AdminBundle:Unidadorganizativa:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Unidadorganizativa entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Unidadorganizativa();
        $form = $this->createForm(new UnidadorganizativaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unidadorganizativa_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Unidadorganizativa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Unidadorganizativa entity.
     *
     */
    public function newAction()
    {
        $entity = new Unidadorganizativa();
        $form   = $this->createForm(new UnidadorganizativaType(), $entity);

        return $this->render('AdminBundle:Unidadorganizativa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Unidadorganizativa entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Unidadorganizativa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidadorganizativa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Unidadorganizativa:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Unidadorganizativa entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Unidadorganizativa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidadorganizativa entity.');
        }

        $editForm = $this->createForm(new UnidadorganizativaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Unidadorganizativa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Unidadorganizativa entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Unidadorganizativa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidadorganizativa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UnidadorganizativaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unidadorganizativa_edit', array('id' => $id)));
        }

        return $this->render('AdminBundle:Unidadorganizativa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Unidadorganizativa entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Unidadorganizativa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Unidadorganizativa entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('unidadorganizativa'));
    }

    /**
     * Creates a form to delete a Unidadorganizativa entity by id.
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
