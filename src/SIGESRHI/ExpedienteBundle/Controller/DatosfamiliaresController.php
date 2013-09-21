<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares;
use SIGESRHI\ExpedienteBundle\Form\DatosfamiliaresType;

/**
 * Datosfamiliares controller.
 *
 */
class DatosfamiliaresController extends Controller
{
    /**
     * Lists all Datosfamiliares entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Datosfamiliares')->findAll();

        return $this->render('ExpedienteBundle:Datosfamiliares:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Datosfamiliares entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Datosfamiliares();
        $form = $this->createForm(new DatosfamiliaresType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosfamiliares_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Datosfamiliares:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Datosfamiliares entity.
     *
     */
    public function newAction()
    {
        $entity = new Datosfamiliares();
        $form   = $this->createForm(new DatosfamiliaresType(), $entity);

        return $this->render('ExpedienteBundle:Datosfamiliares:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Datosfamiliares entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosfamiliares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosfamiliares entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Datosfamiliares:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Datosfamiliares entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosfamiliares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosfamiliares entity.');
        }

        $editForm = $this->createForm(new DatosfamiliaresType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Datosfamiliares:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Datosfamiliares entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Datosfamiliares')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Datosfamiliares entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DatosfamiliaresType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosfamiliares_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Datosfamiliares:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Datosfamiliares entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Datosfamiliares')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Datosfamiliares entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosfamiliares'));
    }

    /**
     * Creates a form to delete a Datosfamiliares entity by id.
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
