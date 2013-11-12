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
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column;

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
        $source = new Entity('ExpedienteBundle:Solicitudempleo','grupo_pruebapsicologica');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->Join($tableAlias.'.idexpediente','e')
                       ->andWhere('e.tipoexpediente = :inv')
                       ->orWhere('e.tipoexpediente = :val')
                       ->setParameter('inv','I')
                       ->setParameter('val','A');
            }
        );

        $em = $this->getDoctrine()->getManager();
        //$expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedientes2();
        //$source->initQueryBuilder($expedienteinfo);
        // Attach the source to the grid
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");
        
        //crear columna
        //$miColumna = new TextColumn(array('id' => 'nombrecompleto', 'title' => 'Nombres', 'filterable'=> true, 'filter'=> 'input', 'size' => '-1', 'type'=>'text', 'selectFrom'=>'nombres'));
        //$grid->addColumn($miColumna, 3);
        
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Invalido')
                             ->setClass('text-error');                    
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                //concat columns
                //$row->setField('nombres', $row->getField('nombres')." ".$row->getField('primerapellido')." ".$row->getField('segundoapellido') );                       
                //$row->setField('nombrecompleto', $row->getField('nombres'));
                return $row;
            }
        );
        //Manipular columna
        /*$grid->getColumn('idexpediente.tipoexpediente')->setTitle(
            'title'
        );*/
        
        //$grid->getColumn('nombrecompleto')->setFilterable(true);
        
        // Attach a rowAction to the Actions Column
        $rowAction1 = new RowAction('Ingresar', 'pruebapsicologica_new');
        $rowAction1->setColumn('info_column');
        //Setear parametros al route
        //$rowAction1->setRouteParameters(array('id','exp'=>''));
        //manipulamos la presentacion del rowaction
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                if ($row->getField('idexpediente.idpruebapsicologica.id') != NULL) {
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
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
         // Manage the grid redirection, exports and the response of the controller
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "");
        $breadcrumbs->addItem("Registrar resultados Prueba Psicologica", $this->get("router")->generate("pruebapsicologica"));

        return $grid->getGridResponse('ExpedienteBundle:Pruebapsicologica:indexExpedientes.html.twig');

    }

    /**
     * Creates a new Pruebapsicologica entity.
     *
     */
    public function createAction(Request $request)
    {
        //$request = $this->getRequest();
        $idexp=$request->get('exp');

        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        $entity  = new Pruebapsicologica();
        $entity->setIdexpediente($expediente);
        $form = $this->createForm(new PruebapsicologicaType(), $entity);        
        $form->bind($request);

        if ($form->isValid()) {            
            $band=0;
            switch ($entity->getResultadocoeficiente()) {
                 case 'superior':
                     if($entity-> getCalificacioncoeficiente()<120 || $entity-> getCalificacioncoeficiente()>129){
                        $band=1;
                     }
                     break;
                 case 'alto':
                     if($entity-> getCalificacioncoeficiente()<110 || $entity-> getCalificacioncoeficiente()>119){
                        $band=1;
                     }
                     break;
                 case 'normal':
                     if($entity-> getCalificacioncoeficiente()<90 || $entity-> getCalificacioncoeficiente()>109){
                        $band=1;
                     }                     
                     break;
                 case 'bajo':
                    if($entity-> getCalificacioncoeficiente()<80 || $entity-> getCalificacioncoeficiente()>89){
                        $band=1;
                     }
                     break;
                 default:
                        $band=1;
                     break;
             }         
            if($band==0){
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('new','Prueba Psicologica Registrada correctamente');
                return $this->redirect($this->generateUrl('pruebapsicologica_show', array('id' => $entity->getId())));
            }
            else{
                $this->get('session')->getFlashBag()->add('calificacion','No corresponde al rango');
            }   
        }
        $this->get('session')->getFlashBag()->add('errornew','Errores en la Prueba Psicologica registrada');
        return $this->render('ExpedienteBundle:Pruebapsicologica:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
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
        $entity->setIdexpediente($expediente);
        $form   = $this->createForm(new PruebapsicologicaType(), $entity);

        //$em = $this->getDoctrine()->getManager();
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "");
        $breadcrumbs->addItem("Registrar Prueba Psicologica","");


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
            'delete_form' => $deleteForm->createView(),        
            ));
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
            throw $this->createNotFoundException('No fue posible cargar el formulario, Intentelo de nuevo.');
        }

        $editForm = $this->createForm(new PruebapsicologicaType($expediente), $entity);
        $deleteForm = $this->createDeleteForm($request->query->get('exp'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "");
        $breadcrumbs->addItem("Editar resultados Prueba Psicologica","");

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
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $exp = $request->query->get('exp');
        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($exp);
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible cargar el formulario, Intentelo de nuevo.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PruebapsicologicaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('edit','Prueba Psicologica ingresada correctamente');
            return $this->redirect($this->generateUrl('pruebapsicologica_edit', array('id' => $id,'exp'=>$exp)));
        }
        $this->get('session')->getFlashBag()->add('editerror','Error en la información de la Prueba Psicologica');
        return $this->render('ExpedienteBundle:Pruebapsicologica:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'expediente'  =>$expedienteinfo,
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
