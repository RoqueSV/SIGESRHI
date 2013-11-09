<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Form\ExpedienteType;
use SIGESRHI\ExpedienteBundle\Form\ExpDocumentoDigitalType;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Expediente controller.
 *
 */
class ExpedienteController extends Controller
{
    /**
     * Lists all Expediente entities.
     *
     */
    public function indexAction()
    {
            $source = new Entity('ExpedienteBundle:Solicitudempleo','vista_basica_expediente');
            $grid = $this->get('grid');
            $grid->setSource($source);  
            $grid->setNoDataMessage("No se encontraron resultados");
            $source->manipulateRow(
                function ($row)
                {                    
                    if($row->getField('idexpediente.tipoexpediente')!='I'){
                        return null;
                    }
                    return $row;
                }
            );
            $rowAction1 = new RowAction('Validar', 'expediente_validar');
            $rowAction1->setColumn('info_column');
            $rowAction1->manipulateRender(
                function ($action, $row)
                {
                    $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                    return $action; 
                }
            );
            $grid->addRowAction($rowAction1); 

            $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
            
            return $grid->getGridResponse('ExpedienteBundle:Expediente:index.html.twig');

        }
    
    /*      $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('ExpedienteBundle:Expediente')->findAll();

            return $this->render('ExpedienteBundle:Expediente:index.html.twig', array(
                'entities' => $entities,
            ));*/
    

    /**
     * Creates a new Expediente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Expediente();
        $form = $this->createForm(new ExpedienteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('expediente_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Expediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Expediente entity.
     *
     */
    public function newAction()
    {
        $entity = new Expediente();
        $form   = $this->createForm(new ExpedienteType(), $entity);

        return $this->render('ExpedienteBundle:Expediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Expediente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Expediente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Expediente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $editForm = $this->createForm(new ExpedienteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Expediente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Expediente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ExpedienteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('expediente_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Expediente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Expediente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Expediente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('expediente'));
    }

    /**
     * Creates a form to delete a Expediente entity by id.
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


/* Registra los documentos digitales para un expediente*/
public function RegistraDocumentosDAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $editForm = $this->createForm(new ExpDocumentoDigitalType(), $entity);

        return $this->render('ExpedienteBundle:Expediente:RegistraDocDigi.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

/* Registra una solicitud como valida */
public function validarAction()
    {
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteInvalido($request->query->get('exp'));
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        //$entity = new Pruebapsicologica();
        //$entity->setIdexpediente($expediente);
        //$form   = $this->createForm(new PruebapsicologicaType(), $entity);

        //$em = $this->getDoctrine()->getManager();
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);        

        return $this->render('ExpedienteBundle:Expediente:validar.html.twig', array(          
            'expediente' => $expedienteinfo,
        ));
    }

}
