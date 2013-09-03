<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\Centrounidad;
use SIGESRHI\AdminBundle\Form\CentrounidadType;

/**
 * Centrounidad controller.
 *
 */
class CentrounidadController extends Controller
{
    /**
     * Lists all Centrounidad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Centrounidad')->findAll();

        return $this->render('AdminBundle:Centrounidad:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Centrounidad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Centrounidad();
        $form = $this->createForm(new CentrounidadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('centrounidad_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Centrounidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Centrounidad entity.
     *
     */
    public function newAction()
    {
        $entity = new Centrounidad();
        $form   = $this->createForm(new CentrounidadType(), $entity);

        return $this->render('AdminBundle:Centrounidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Centrounidad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Centrounidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Centrounidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Centrounidad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Centrounidad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Centrounidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Centrounidad entity.');
        }

        $editForm = $this->createForm(new CentrounidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Centrounidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Centrounidad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Centrounidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Centrounidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CentrounidadType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('centrounidad_edit', array('id' => $id)));
        }

        return $this->render('AdminBundle:Centrounidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Centrounidad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Centrounidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Centrounidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('centrounidad'));
    }

    /**
     * Creates a form to delete a Centrounidad entity by id.
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
