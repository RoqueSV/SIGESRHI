<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Concurso;
use SIGESRHI\ExpedienteBundle\Form\ConcursoType;

/**
 * Concurso controller.
 *
 */
class ConcursoController extends Controller
{
    /**
     * Lists all Concurso entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Concurso')->findAll();

        return $this->render('ExpedienteBundle:Concurso:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Concurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Concurso();
        $form = $this->createForm(new ConcursoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('concurso_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Concurso entity.
     *
     */
    public function newAction()
    {
        $entity = new Concurso();
        $form   = $this->createForm(new ConcursoType(), $entity);

        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Concurso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Concurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Concurso entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $editForm = $this->createForm(new ConcursoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Concurso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ConcursoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('concurso_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Concurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Concurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('concurso'));
    }

    /**
     * Creates a form to delete a Concurso entity by id.
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
