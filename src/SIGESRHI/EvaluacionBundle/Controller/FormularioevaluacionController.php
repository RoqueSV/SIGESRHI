<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Opcion;
use SIGESRHI\EvaluacionBundle\Form\FormularioevaluacionType;
use SIGESRHI\EvaluacionBundle\Form\FactorevaluacionType;


use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;
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
        $source = new Entity('EvaluacionBundle:Formularioevaluacion', 'grupo_formulario');
        // Get a grid instance
        $grid = $this->get('grid');

    /*    //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Consultar Solicitud de Empleo", $this->get("router")->generate("solicitud_caspirante"));
    */    //fin camino de miga
       
        //seleccionamos solo los formularios que estan activos      
      $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".estadoform = 'A' ");
        }
            );

        // Attach the source to the grid
        $grid->setId('grid_formularios');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('id', 'desc');
        
        $rowAction1 = new RowAction('Consultar', 'formularioevaluacion_show');

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('EvaluacionBundle:Formularioevaluacion:index.html.twig');
    }

    /**
     * Creates a new Formularioevaluacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Formularioevaluacion();
        //establecemos el estado del formulario a "activo" por defecto
        $entity->setEstadoform('A');

        $form = $this->createForm(new FormularioevaluacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Asignamos al formulario todos los puntajes registrados
               $puntajes = $em->getRepository('EvaluacionBundle:Puntaje')->findAll();
               
                foreach($puntajes as $puntaje)
                {
                    
                    $entity->addPuntajes($puntaje);
                    //$puntaje->addIdformulario($entity);
                    //$em->persist($puntaje);
                }
            

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new','Datos generales del formulario registrado correctamente.'); 
            return $this->redirect($this->generateUrl('formularioevaluacion_editfactores', array('id' => $entity->getId())));
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

        return $this->render('EvaluacionBundle:Formularioevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }


    public function editFactoresAction($id)
    {
        $factorevaluacion = new Factorevaluacion();
        $Opciones = new Opcion();
        $factorevaluacion->getOpciones()->add($Opciones);
        $factor_form   = $this->createForm(new FactorevaluacionType(), $factorevaluacion);
        
        $em = $this->getDoctrine()->getManager();
        $evaluacion = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

        if (!$evaluacion) {
            throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
        }

        return $this->render('EvaluacionBundle:Formularioevaluacion:editarfactores.html.twig', array(
            'factorevaluacion' => $factorevaluacion,
            'form'   => $factor_form->createView(),
            'evaluacion'=> $evaluacion,
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

            $this->get('session')->getFlashBag()->add('msg', 'Datos generales del Formulario modificado correctamente.');
            return $this->redirect($this->generateUrl('formularioevaluacion_show', array('id' => $id)));
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

    public function deshabilitaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
            }

            $entity->setEstadoform('I');
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('del', 'Formulario de evaluación deshabilitado correctamente.'); 
            return $this->redirect($this->generateUrl('formularioevaluacion'));
    }//deshabilita
}
