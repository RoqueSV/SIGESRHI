<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Beneficiario;
use SIGESRHI\ExpedienteBundle\Form\BeneficiarioType;

/**
 * Beneficiario controller.
 *
 */
class BeneficiarioController extends Controller
{
    /**
     * Lists all Beneficiario entities.
     *
     */
    
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Beneficiario')->findAll();

        return $this->render('ExpedienteBundle:Beneficiario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Beneficiario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Beneficiario();
        $form = $this->createForm(new BeneficiarioType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('beneficiario_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Beneficiario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Beneficiario entity.
     *
     */
    public function newAction()
    {
        $entity = new Beneficiario();
        $form   = $this->createForm(new BeneficiarioType(), $entity);

        return $this->render('ExpedienteBundle:Beneficiario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Beneficiario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Beneficiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Beneficiario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Beneficiario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Beneficiario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Beneficiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Beneficiario entity.');
        }

        $editForm = $this->createForm(new BeneficiarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Beneficiario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Beneficiario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Beneficiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Beneficiario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BeneficiarioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('beneficiario_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Beneficiario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Beneficiario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Beneficiario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Beneficiario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('beneficiario'));
    }

    /**
     * Creates a form to delete a Beneficiario entity by id.
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
