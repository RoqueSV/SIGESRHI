<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Contratacion;
use SIGESRHI\ExpedienteBundle\Form\ContratacionType;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

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

    public function registrarAction(){

        $source = new Entity('ExpedienteBundle:Expediente','grupo_contratacion_aspirante');
        
        $grid = $this->get('grid');


        /* Aspirantes validos */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->setParameter('tipo','A');
            }
        );   
        
        $grid->setId('grid_contratacion');
        $grid->setSource($source);       

         //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre','operatorsVisible'=>false));
        $grid->addColumn($NombreEmpleados,2);  
        $NombrePlazas = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idsolicitudempleo.idplaza.nombreplaza','title' => 'Plaza solicitada','operatorsVisible'=>false,'joinType'=>'inner'));
        $grid->addColumn($NombrePlazas,3);      
        
        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'contratacion_new');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 1));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        
        return $grid->getGridResponse('ExpedienteBundle:Contratacion:index.html.twig');
    }

    public function consultarAction(){

        $source = new Entity('ExpedienteBundle:Expediente','grupo_contratacion_empleado');
        
        $grid = $this->get('grid');


        /* Empleados validos */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->setParameter('tipo','E');
            }
        );   
        
        $grid->setId('grid_contratacion');
        $grid->setSource($source);       

         //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre','operatorsVisible'=>false,'joinType'=>'inner'));
        $grid->addColumn($NombreEmpleados,3);  
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false,'joinType'=>'inner'));
        $grid->addColumn($CodigoEmpleados,2);      
        
        // Crear
        $rowAction1 = new RowAction('Mostrar', 'contratacion_show');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id'=> $row->getField('idempleado.idcontratacion.id')));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('codigos', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar datos de contratación", $this->get("router")->generate("contratacion"));
        
        return $grid->getGridResponse('ExpedienteBundle:Contratacion:index.html.twig');
    }

    public function registrarEmpleadoAction(){

        $source = new Entity('ExpedienteBundle:Expediente','grupo_contratacion_empleado');
        
        $grid = $this->get('grid');


        /* Empleados validos */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->setParameter('tipo','E');
            }
        );   
        
        $grid->setId('grid_contratacion');
        $grid->setSource($source);       

         //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre','operatorsVisible'=>false,'joinType'=>'inner'));
        $grid->addColumn($NombreEmpleados,3);  
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false,'joinType'=>'inner'));
        $grid->addColumn($CodigoEmpleados,2);      
        
        // Crear
        $rowAction1 = new RowAction('Registrar', 'contratacion_new');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 2));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('codigos', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        
        return $grid->getGridResponse('ExpedienteBundle:Contratacion:index.html.twig');
    }

    /**
     * Creates a new Contratacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Contratacion();

        //Establecer tipo
        $entity->setTipocontratacion($request->get('tipo'));

        $form = $this->createForm(new ContratacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
             $em = $this->getDoctrine()->getManager();
             
             /***** Si es empleado nuevo *******/
             //crear empleado para establecer la relación.
             $empleado = new Empleado();
             $idexpediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->get('idexpediente'));
             $empleado->setIdexpediente($idexpediente);
             $empleado->setCodigoempleado($request->get('codempleado'));
             
             $em->persist($empleado);
             $em->flush();
             
             //asignamos el id del nuevo empleado
             $entity->setIdempleado($empleado);
             
             $em->persist($entity);
             $em->flush();

             //Actualizar expediente
             $expedienteinfo = $em->getRepository('ExpedienteBundle:Contratacion')->actualizarEstadoExpediente($request->get('idexpediente'));
             /**********************************/


             if(count($entity->getIdempleado()->getIdcontratacion())==0){
             return $this->redirect($this->generateUrl('hojaservicio_new', array('id' => $request->get('idexpediente'))));
            }
         return $this->redirect($this->generateUrl('contratacion_show', array('id' => $entity->getId())));
        }
        
        $expediente = $em->getRepository('ExpedienteBundle:Contratacion')->obtenerAspiranteValido($request->get('idexpediente'));
        $tipo=$request->get('tipo');
        return $this->render('ExpedienteBundle:Contratacion:contratacion.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'expediente'=>$expediente,
            'tipo'=>$tipo,
        ));
    }

    /**
     * Displays a form to create a new Contratacion entity.
     *
     */
    public function newAction()
    {

        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Contratacion')->obtenerAspiranteValido($request->query->get('id'));
    
        $idexpediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('id'));
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        
        if ($request->get('tipogrid')==1){
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        $breadcrumbs->addItem($idexpediente->getIdsolicitudempleo()->getNumsolicitud(),  $this->get("router")->generate("contratacion_new"));
        }
        else{
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        $breadcrumbs->addItem($idexpediente->getIdempleado()->getCodigoempleado(),  $this->get("router")->generate("contratacion_new"));
        }
        return $this->render('ExpedienteBundle:Contratacion:new.html.twig', array(          
            'expediente' => $expediente,
            'tipogrid' => $request->query->get('tipogrid'),
        ));
    }

    public function tipoContratoAction()
    {
        $request=$this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $tipo=$request->get('tipo');

        $expediente = $em->getRepository('ExpedienteBundle:Contratacion')->obtenerAspiranteValido($request->get('idexp'));
        foreach ($expediente as $exp) {
          $plaza = $exp['nombreplaza'];
        }
        $idplaza = $em->getRepository('AdminBundle:Plaza')->findOneByNombreplaza($plaza);
        $idrefrenda = $em->getRepository('AdminBundle:RefrendaAct')->findOneByIdplaza($idplaza);
        
        $entity = new Contratacion();
        $entity->setPuesto($idrefrenda);

        $form = $this->createForm(new ContratacionType(), $entity);
        
        //Camino de migas
        $idexpediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('idexp'));
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));

        if ($tipo == 1){ //Ley de salarios
        $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_new"));
          return $this->render('ExpedienteBundle:Contratacion:contratacion.html.twig', array(
         'entity' => $entity,
         'expediente' => $expediente,
         'tipo' => $tipo,
         'form' => $form->createView(),
         ));
        }
       else if ($tipo == 2){ //Contrato
        $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_new"));
          return $this->render('ExpedienteBundle:Contratacion:contratacion.html.twig', array(
         'entity' => $entity,
         'expediente' => $expediente,
         'tipo' => $tipo,
         'form' => $form->createView(),
         ));
       }


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
        
        $contratacion = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar datos de contratación", $this->get("router")->generate("contratacion_consultar"));
        $breadcrumbs->addItem($contratacion->getIdempleado()->getCodigoempleado(),  $this->get("router")->generate("contratacion_consultar"));

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
