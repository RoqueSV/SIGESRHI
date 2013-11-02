<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Segurovida;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Beneficiario;
use SIGESRHI\ExpedienteBundle\Form\SegurovidaType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

/**
 * Segurovida controller.
 *
 */
class SegurovidaController extends Controller
{
    /**
     * Lists all Segurovida entities.
     *
     */
    public function indexAction()
        {
        // Creates simple grid based on your entity (ORM)
        $source = new Entity('ExpedienteBundle:Expediente','grupo_segurovida');

        // Get a grid instance
        $grid = $this->get('grid');

        // Attach the source to the grid
        $grid->setSource($source);

        // Attach a rowAction to the Actions Column
        $rowAction1 = new RowAction('Crear', 'segurovida_new');
        $rowAction1->setRouteParameters(array('id'));
        $rowAction1->setColumn('info_column');
        $grid->addRowAction($rowAction1);

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida"));

        return $grid->getGridResponse('ExpedienteBundle:Segurovida:index.html.twig');
    }

    /**
     * Creates a new Segurovida entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Segurovida();
        $form = $this->createForm(new SegurovidaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $entity->setFechaseguro(new \DateTime("now"));
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('segurovida_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Segurovida entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();     //Recibir valores por get
        $entity = new Segurovida();
        
        /*Agregamos datos de beneficiario*/
        $datosBeneficiario = new Beneficiario();
        $datosBeneficiario->name = 'Beneficiarios';
        $entity->getIdBeneficiario()->add($datosBeneficiario);
        
        /* Obtener datos expediente */
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($request->query->get('id'));
        
        $form   = $this->createForm(new SegurovidaType(), $entity);
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida"));
        $breadcrumbs->addItem("Registro", $this->get("router")->generate("segurovida_new"));

        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Segurovida entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Segurovida:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Segurovida entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }

        $editForm = $this->createForm(new SegurovidaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Segurovida:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Segurovida entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SegurovidaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('segurovida_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Segurovida:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Segurovida entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Segurovida entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('segurovida'));
    }

    /**
     * Creates a form to delete a Segurovida entity by id.
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
