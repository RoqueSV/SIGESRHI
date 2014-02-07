<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Form\FormularioevaluacionType;

/**
 * Formularioevaluacion controller.
 *
 */
class FormularioevaluacionController extends Controller
{
    /**
     * Lists all Formularioevaluacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->findAll();

        return $this->render('EvaluacionBundle:Formularioevaluacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Formularioevaluacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Formularioevaluacion();
        $form = $this->createForm(new FormularioevaluacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formularioevaluacion_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Formularioevaluacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Formularioevaluacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Formularioevaluacion();

        $Factores = new Factorevaluacion();
        $entity->getFactores()->add($Factores);


        $form   = $this->createForm(new FormularioevaluacionType(), $entity);

        return $this->render('EvaluacionBundle:Formularioevaluacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Formularioevaluacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Formularioevaluacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Formularioevaluacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
        }

        $editForm = $this->createForm(new FormularioevaluacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Formularioevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Formularioevaluacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FormularioevaluacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formularioevaluacion_edit', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Formularioevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Formularioevaluacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formularioevaluacion'));
    }

    /**
     * Creates a form to delete a Formularioevaluacion entity by id.
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
