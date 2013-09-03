<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\Acceso;
use SIGESRHI\AdminBundle\Form\AccesoType;

/**
 * Acceso controller.
 *
 */
class AccesoController extends Controller
{
    /**
     * Lists all Acceso entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Acceso')->findAll();

        return $this->render('AdminBundle:Acceso:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Acceso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Acceso();
        $form = $this->createForm(new AccesoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('acceso_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Acceso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Acceso entity.
     *
     */
    public function newAction()
    {
        $entity = new Acceso();
        $form   = $this->createForm(new AccesoType(), $entity);

        return $this->render('AdminBundle:Acceso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Acceso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acceso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Acceso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Acceso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Acceso entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acceso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Acceso entity.');
        }

        $editForm = $this->createForm(new AccesoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Acceso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Acceso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acceso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Acceso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AccesoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('acceso_edit', array('id' => $id)));
        }

        return $this->render('AdminBundle:Acceso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Acceso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Acceso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Acceso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('acceso'));
    }

    /**
     * Creates a form to delete a Acceso entity by id.
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
