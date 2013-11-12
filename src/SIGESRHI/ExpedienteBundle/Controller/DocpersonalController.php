<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Docpersonal;
use SIGESRHI\ExpedienteBundle\Form\DocpersonalType;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column;

/**
 * Docpersonal controller.
 *
 * @Route("/docpersonal")
 */
class DocpersonalController extends Controller
{
    /**
     * Lists all Docpersonal entities.
     *
     * @Route("/", name="docpersonal")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {


    /*    $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Docpersonal')->findAll();

        return array(
            'entities' => $entities,
        ); */
    }

    /**
     * Creates a new Docpersonal entity.
     *
     * @Route("/", name="docpersonal_create")
     * @Method("POST")
     * @Template("ExpedienteBundle:Docpersonal:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Docpersonal();
        $form = $this->createForm(new DocpersonalType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docpersonal_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Docpersonal entity.
     *
     * @Route("/new", name="docpersonal_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Docpersonal();
        $form   = $this->createForm(new DocpersonalType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Docpersonal entity.
     *
     * @Route("/{id}", name="docpersonal_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Docpersonal entity.
     *
     * @Route("/{id}/edit", name="docpersonal_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $editForm = $this->createForm(new DocpersonalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Docpersonal entity.
     *
     * @Route("/{id}", name="docpersonal_update")
     * @Method("PUT")
     * @Template("ExpedienteBundle:Docpersonal:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DocpersonalType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docpersonal_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Docpersonal entity.
     *
     * @Route("/{id}", name="docpersonal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Docpersonal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docpersonal'));
    }

    /**
     * Creates a form to delete a Docpersonal entity by id.
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
