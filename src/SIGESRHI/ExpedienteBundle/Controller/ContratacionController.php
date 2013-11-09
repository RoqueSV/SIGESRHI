<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Contratacion;
use SIGESRHI\ExpedienteBundle\Form\ContratacionType;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

/**
 * Contratacion controller.
 *
 */
class ContratacionController extends Controller
{
    /**
     * Lists all Contratacion entities.
     *
     */

    public function indexAction(){

        $source = new Entity('ExpedienteBundle:Expediente','grupo_contratacion');
        
        $grid = $this->get('grid');
   
        $source->manipulateRow(
            function ($row) 
            {
                                   
            // Mostrar solo aspirantes validos
            if ($row->getField('tipoexpediente')!='A') {
            return null;
            }
        
            return $row;
            }
        );
        
        //$grid->setId('grid_segurovida');
        $grid->setSource($source);              
        
        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'contratacion_new');
        $rowAction1->setRouteParameters(array('id'));
        $rowAction1->setColumn('info_column');
        $grid->addRowAction($rowAction1);
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida"));
        
        return $grid->getGridResponse('ExpedienteBundle:Contratacion:index.html.twig');
    }

    /*public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Contratacion')->findAll();

        return $this->render('ExpedienteBundle:Contratacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }*/

    /**
     * Creates a new Contratacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Contratacion();
        $form = $this->createForm(new ContratacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contratacion_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Contratacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Contratacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Contratacion();
        $form   = $this->createForm(new ContratacionType(), $entity);

        return $this->render('ExpedienteBundle:Contratacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contratacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Contratacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Contratacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }

        $editForm = $this->createForm(new ContratacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Contratacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Contratacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContratacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contratacion_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Contratacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contratacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contratacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contratacion'));
    }

    /**
     * Creates a form to delete a Contratacion entity by id.
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
