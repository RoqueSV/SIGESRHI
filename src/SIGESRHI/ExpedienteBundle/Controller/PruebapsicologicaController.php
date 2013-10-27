<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Repositorio\ExpedienteRepository;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica;
use SIGESRHI\ExpedienteBundle\Form\PruebapsicologicaType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Grid;

/**
 * Pruebapsicologica controller.
 *
 */
class PruebapsicologicaController extends Controller
{
    /**
     * Lists all Pruebapsicologica entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->findAll();

        return $this->render('ExpedienteBundle:Pruebapsicologica:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function indexExpedientesAction()
    {
        //$em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedientes();
        //return $this->render('ExpedienteBundle:Pruebapsicologica:indexExpedientes.html.twig', array('entities' => $entities,));
        // Creates simple grid based on your entity (ORM)
        $source = new Entity('ExpedienteBundle:SolicitudEmpleo','grupo_pruebapsicologica');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.nombres != :es')
                      ->setParameter('es','I');
            }
        );

        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedientes2();
        //$source->initQueryBuilder($expedienteinfo);
        // Attach the source to the grid
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column quantity if anarticle is sold out
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Invalido');                    
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                       
                    }
                }
                else{                    
                    return null;
                }
                return $row;
            }
        );
        // Attach a rowAction to the Actions Column
        $rowAction1 = new RowAction('Ingresar', 'pruebapsicologica_new');
        $rowAction1->setColumn('info_column');
        //Setear parametros al route
        //$rowAction1->setRouteParameters(array('id','exp'=>''));
        //manipulamos la presentacion del rowaction
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                if ($row->getField('idexpediente.tipoexpediente') == 'Válido') {
                    $action->setTitle('Editar')
                           ->setRoute('pruebapsicologica_edit');                            
                }
                else{

                }
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);     

        $grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
         // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('ExpedienteBundle:Pruebapsicologica:indexExpedientes.html.twig');
    }

    /**
     * Creates a new Pruebapsicologica entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Pruebapsicologica();
        $form = $this->createForm(new PruebapsicologicaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pruebapsicologica_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Pruebapsicologica:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Pruebapsicologica entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        $entity = new Pruebapsicologica();
        $form   = $this->createForm(new PruebapsicologicaType($expediente), $entity);

        //$em = $this->getDoctrine()->getManager();
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);        

        return $this->render('ExpedienteBundle:Pruebapsicologica:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'form'   => $form->createView(),            
        ));
    }

    /**
     * Finds and displays a Pruebapsicologica entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pruebapsicologica entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Pruebapsicologica:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Pruebapsicologica entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($request->query->get('exp'));
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pruebapsicologica entity.');
        }

        $editForm = $this->createForm(new PruebapsicologicaType($expediente), $entity);
        $deleteForm = $this->createDeleteForm($request->query->get('exp'));

        return $this->render('ExpedienteBundle:Pruebapsicologica:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'expediente'  =>$expedienteinfo,
        ));
    }

    /**
     * Edits an existing Pruebapsicologica entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pruebapsicologica entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PruebapsicologicaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pruebapsicologica_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Pruebapsicologica:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pruebapsicologica entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pruebapsicologica entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pruebapsicologica'));
    }

    /**
     * Creates a form to delete a Pruebapsicologica entity by id.
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
