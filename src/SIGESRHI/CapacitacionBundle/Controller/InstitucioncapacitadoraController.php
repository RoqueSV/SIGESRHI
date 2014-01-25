<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora;
use SIGESRHI\CapacitacionBundle\Form\InstitucioncapacitadoraType;

/**
 * Institucioncapacitadora controller.
 *
 */
class InstitucioncapacitadoraController extends Controller
{
    /**
     * Lists all Institucioncapacitadora entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CapacitacionBundle:Institucioncapacitadora')->findAll();

        return $this->render('CapacitacionBundle:Institucioncapacitadora:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Institucioncapacitadora entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Institucioncapacitadora();
        $form = $this->createForm(new InstitucioncapacitadoraType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('institucion_show', array('id' => $entity->getId())));
        }

        return $this->render('CapacitacionBundle:Institucioncapacitadora:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Institucioncapacitadora entity.
     *
     */
    public function newAction()
    {
        $entity = new Institucioncapacitadora();
        $form   = $this->createForm(new InstitucioncapacitadoraType(), $entity);

          // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Instituciones", $this->get("router")->generate("pantalla_instituciones"));
        $breadcrumbs->addItem("Registrar institución", $this->get("router")->generate("hello_page"));

        return $this->render('CapacitacionBundle:Institucioncapacitadora:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Institucioncapacitadora entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Institucioncapacitadora')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institucioncapacitadora entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

         // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Instituciones", $this->get("router")->generate("pantalla_instituciones"));
        $breadcrumbs->addItem("Registrar institución", $this->get("router")->generate("institucion_new"));
        $breadcrumbs->addItem("Datos de registro", $this->get("router")->generate("institucion_new"));

        return $this->render('CapacitacionBundle:Institucioncapacitadora:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Institucioncapacitadora entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Institucioncapacitadora')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institucioncapacitadora entity.');
        }

        $editForm = $this->createForm(new InstitucioncapacitadoraType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Institucioncapacitadora:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Institucioncapacitadora entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Institucioncapacitadora')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institucioncapacitadora entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new InstitucioncapacitadoraType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('institucion_edit', array('id' => $id)));
        }

        return $this->render('CapacitacionBundle:Institucioncapacitadora:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Institucioncapacitadora entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CapacitacionBundle:Institucioncapacitadora')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Institucioncapacitadora entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('institucion'));
    }

    /**
     * Creates a form to delete a Institucioncapacitadora entity by id.
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
