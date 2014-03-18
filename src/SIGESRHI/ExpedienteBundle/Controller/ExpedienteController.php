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
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Expediente')->findAll();

        return $this->render('ExpedienteBundle:Expediente:index.html.twig', array(
            'entities' => $entities,
        ));    
    }

    public function indexAspirantesAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo','vista_basica_expediente');
        $grid = $this->get('grid');
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere('_idexpediente.tipoexpediente = :inv')
                       ->setParameter('inv','I');
            }
        );
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false, "filterable" => true));
        $Nombre = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($Nombre,2);
        $grid->addColumn($plaza,3);
        $rowAction1 = new RowAction('Validar', 'expediente_validar');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action; 
            }
        );
        $grid->setId("grid_aspirantes_invalidos");
        $grid->addRowAction($rowAction1); 

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("pantalla_aspirante",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Validar Expediente",  "");
        
        return $grid->getGridResponse('ExpedienteBundle:Expediente:index.html.twig');
    }    

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
public function registraDocDigAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad expediente.');
        }

        $editForm = $this->createForm(new ExpDocumentoDigitalType(), $entity);

        return $this->render('ExpedienteBundle:Expediente:RegistraDocDigi.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }


/* Formulario para registrar una solicitud como valida */
public function validarAction()
    {
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteInvalido($request->query->get('exp'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("pantalla_aspirante",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Validar Expediente",  $this->get("router")->generate("expediente_aspirantes"));
        $breadcrumbs->addItem($expedienteinfo[0]['nombrecompleto'], "");
        return $this->render('ExpedienteBundle:Expediente:validar.html.twig', array(          
            'expediente' => $expedienteinfo,
        ));
    }

/* Confirma un expediente de aspirante como valido*/
public function confirmarValidoAction($id,$idsol)
    {
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->registrarValido($id);
        
        //funcion para asiganar num solicitud
        $numSolicitud;        
        //establecemos el id de la solicitud
        $query = $em->createQuery("SELECT COUNT(s.numsolicitud) AS  numsolicitud 
        FROM ExpedienteBundle:Solicitudempleo s 
        where  substring(s.numsolicitud,locate('-',s.numsolicitud)+1, 4) = :actual")
       ->setParameter('actual', date('Y'));

        $Resultado = $query->getsingleResult();

        $num=$Resultado['numsolicitud'];

        if($num==0){

            $numsolicitud="1-".date('Y');
        }
        if($num > 0){
            $num++;
            $numsolicitud = $num."-".date('Y');
        }

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($idsol);

        $num_anterior=$entity->getNumsolicitud();
        if($num_anterior == 0 ){
            $entity->setNumsolicitud($numsolicitud);
            $em->persist($entity);
            $em->flush();
        }
        //fin funcion

        $this->get('session')->getFlashBag()->add('confirm',"Expediente del aspirante: ".$entity->getNombrecompleto().". Validado correctamente");
        return $this->redirect($this->generateUrl("expediente_aspirantes"));
        
    }


//seleccionar el periodo a eliminar expediente aspirantes antiguos
    public function antAspirantesAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Eliminar por Antigüedad",  $this->get("router")->generate("eliminar_aspirantes"));
        return $this->render('ExpedienteBundle:Expediente:ant.html.twig');
    }

//ver listados a eliminar por antigüedad
    public function showElimAction()
    {        
        //recuperar desde un formulario
        $periodo=$this->get('request')->request->get('periodo');   
        $session = $this->getRequest()->getSession();
        if($periodo==""){
            if($Speriodo = $session->get('Speriodo'))
                $periodo = $Speriodo;
                
        }
        if($periodo!=""){
            $session->set('Speriodo',$periodo);
            $fecha_actual=date('d-m-Y');
            $pedazos=explode('-', $fecha_actual);
            $anofind=+$pedazos[2]-$periodo;
            $fecha_find = $anofind."-".$pedazos[1]."-".$pedazos[0];

            $em = $this->getDoctrine()->getManager();
            $aspirantesElim = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedientesPeriodo($fecha_find);

            $source = new Entity('ExpedienteBundle:Solicitudempleo','lista_expediente');
            $grid = $this->get('grid');
            $grid->setSource($source);  
            $grid->setNoDataMessage("No se encontraron resultados");
            $tableAlias = $source->getTableAlias();
            $source->manipulateQuery(
                function($query) use ($tableAlias, $fecha_find){
                    $query->Join($tableAlias.'.idexpediente','e')
                          ->andWhere('e.tipoexpediente = :inv')
                          ->orWhere('e.tipoexpediente = :val')
                          ->andWhere('e.fechaexpediente <:fecha')                          
                          ->setParameter('fecha', $fecha_find )
                          ->setParameter('inv','I')
                          ->setParameter('val','A');                
                }
            );
            $source->manipulateRow(
                function ($row)
                {
                    // Change the ouput of the column
                    if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                        if($row->getField('idexpediente.tipoexpediente')=='I'){
                            $row->setField('idexpediente.tipoexpediente', 'Invalido');                    
                        }
                        if($row->getField('idexpediente.tipoexpediente')=='A'){
                            $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                        }
                    }
                    return $row;
                }
            );

            $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
            $grid ->setId('grid_eliminar_antiguedad');
            //Camino de migas
            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Eliminar por Antigüedad",  $this->get("router")->generate("eliminar_aspirantes"));
            
            return $grid->getGridResponse('ExpedienteBundle:Expediente:showElim.html.twig',array(
                'aspirantesElim' => $aspirantesElim,
                'fecha' => $fecha_find,
                ));
        }
        else{
            return $this->redirect($this->generateUrl("expediente_elim_ant"));
        }
    }
// Muestra el form principal para eliminar aspirantes
    public function eliminarAspiranteAction(){
        //$request = $this->getRequest();
        //$tipo = $request->query->get('tipo');
        $tipo=$this->get('request')->request->get('tipo');   
        if($tipo=='1'){
            return $this->redirect($this->generateUrl("expediente_elim_ant"));
        }
        elseif ($tipo=='0') {                
            return $this->redirect($this->generateUrl("expediente_elim_indv"));
        }
        else{
             //Camino de migas
            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Eliminar", "");
            return $this->render('ExpedienteBundle:Expediente:seleliminar.html.twig');
        }

    }
//ver listados expedientes a eliminar individualmente
    public function indvAspirantesAction()
    {        
        $em = $this->getDoctrine()->getManager();
        
        $fecha_actual=date('d-m-Y');
        $pedazos=explode('-', $fecha_actual);
        $anofind=+$pedazos[2]-1;
        $fecha_find = $anofind."-".$pedazos[1]."-".$pedazos[0];

        $source = new Entity('ExpedienteBundle:Solicitudempleo','lista_expediente2');
        $grid = $this->get('grid');
        $grid-> setId("grideliminaraspindv");
        $NombreAspirante = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false, 'filterable'=>true, 'visible'=> true));
        $grid->addColumn($NombreAspirante,1);
        $grid->setSource($source);
        $grid->addMassAction(new DeleteMassAction(true));  
        //$grid->setParameter();
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias, $fecha_find){
                $query->Join($tableAlias.'.idexpediente','e')
                      ->andWhere('e.tipoexpediente = :inv')
                      ->orWhere('e.tipoexpediente = :val')
                      ->andWhere('e.fechaexpediente <:fecha')                          
                      ->setParameter('fecha', $fecha_find )
                      ->setParameter('inv','I')
                      ->setParameter('val','A');                
            }
        );
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Invalido');                    
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                return $row;
            }
        );

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante",$this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Eliminar Individualmente",  $this->get("router")->generate("eliminar_aspirantes"));
        
        return $grid->getGridResponse('ExpedienteBundle:Expediente:showElimAll.html.twig');        
    }

//funcion que elimina los expedientes por la fecha
    public function confirmarEliminacionAction(){
        $request = $this->getRequest();
        $fecha = $request->query->get('fecha');
        if($fecha){
            $em = $this->getDoctrine()->getManager();
            $aspirantesElim = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedientesPeriodo($fecha);
            foreach ($aspirantesElim as $asp) {
                 $idExpAsp = $asp['id'];                 
                 $aspirantetarget = $em->getRepository('ExpedienteBundle:Expediente')->find($idExpAsp);            
                 $em->remove($aspirantetarget);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('confirm','Información de Aspirante eliminada exitosamente');
            //return $this->render('ExpedienteBundle:Expediente:seleliminar.html.twig');
            return $this->redirect($this->generateUrl('expediente_elim_ant'));        
        }

    }
//func que muestra empleados activos para pasarlos a inactivos
public function admEmpleadoAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado_activo');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                      ->andWhere('_idempleado_idrefrenda.id is null')
                      ->setParameter('emp','E');
                        
            }            
        );
        $grid->setSource($source);  
        $grid->setNoDataMessage("No existen empleados no asignados a plazas");

        $rowAction1 = new RowAction('Inactivar', 'expediente_inactivar');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1); 
        $grid->setId('grid_adm_activos');

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false));
        $grid->addColumn($CodigoEmpleados,1);
        $grid->addColumn($NombreEmpleados,2);

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Inactivo",  "");
        
        return $grid->getGridResponse('ExpedienteBundle:Expediente:indexEmpleados.html.twig',array(
            'idgrid' => 'grid_adm_activos',
            'showempleados' => 'empleados',
            ));
    } 

/* Formulario para registrar un empleado como inactivo */
public function inactivarEmpleadoAction()
    {
        $request = $this->getRequest();
       
        $idexp=$this->get('request')->request->get('idexp');   
        $em = $this->getDoctrine()->getManager();
        

        //ver expediente a inhabilitar(Principal)
        if($request->query->get('id')!=null) {            
            $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleado($request->get('id'));
            
            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Registrar Inactivo",  "");

            return $this->render('ExpedienteBundle:Expediente:inactivar.html.twig', array(          
                'expediente' => $expedienteinfo,
            ));
        }

       //Si viene del formulario donde confirma eliminación
        elseif($idexp!=null){
            
                $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
                $entity -> setTipoexpediente('X');
                $em -> persist($entity);
                $em -> flush();

                $this->get('session')->getFlashBag()->add('confirm','Empleado registrado como inactivo exitosamente');                
                return $this->redirect($this->generateUrl('expediente_adm_empleado'));            
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleado($idexp);
                
                $breadcrumbs = $this->get("white_october_breadcrumbs");
                $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
                $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
                $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("expediente_adm_empleado"));
                $breadcrumbs->addItem("Registrar Inactivo",  "");

                $this->get('session')->getFlashBag()->add('error','Ingrese un código de acuerdo válido para el Empleado');
                return $this->render('ExpedienteBundle:Expediente:inactivar.html.twig', array(          
                    'expediente' => $expedienteinfo,
                ));
            }
    }
//func que muestra empleados inactivos para pasarlos a activos
public function admEmpleadoInactivoAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado_inactivo');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                        //->andWhere('_idempleado_idcontratacion.fechafincontrato IS NOT NULL')
                        ->setParameter('emp','X');
            }
        );
        //$plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false));
        //$grid->addColumn($plaza,3);
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");

        $rowAction1 = new RowAction('Activar', 'expediente_activar');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1); 

        $grid->setId('grid_adm_inactivos');

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false));
        $grid->addColumn($CodigoEmpleados,1);
        $grid->addColumn($NombreEmpleados,2);
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Inactivo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Activo",  "");
        
        return $grid->getGridResponse('ExpedienteBundle:Expediente:indexEmpleados.html.twig',array(
            'idgrid' => 'grid_adm_inactivos',
            'showempleados' => 'noempleados',
            ));
    } 

    
/* Formulario para registrar un empleado como activo */
public function activarEmpleadoAction()
    {
        $request = $this->getRequest();
        $numacuerdo=$this->get('request')->request->get('numacuerdo');   
        $idexp=$this->get('request')->request->get('idexp');   
        $em = $this->getDoctrine()->getManager();
        //ver expediente a inhabilitar(Principal)
        if($request->query->get('id')!=null AND $numacuerdo==null) {            
            $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleado($request->query->get('id'));

            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Empleado Inactivo",$this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Registrar Activo",  "");

            return $this->render('ExpedienteBundle:Expediente:activar.html.twig', array(          
                'expediente' => $expedienteinfo,
            ));
        }

       //Si viene del formulario donde inserta el num acuerdo
        elseif($idexp!=null){
            //$acuerdovalido = $em->getRepository('ExpedienteBundle:Expediente')->encontrarAcuerdo($numacuerdo);
            $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
            if($entity!=null){
                $entity -> setTipoexpediente('E');
                $em -> persist($entity);
                $em -> flush();

                $this->get('session')->getFlashBag()->add('confirm','Empleado registrado como activo Exitosamente');                
                return $this->redirect($this->generateUrl('expediente_adm_empleado_inactivo'));            
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleado($idexp);

                $breadcrumbs = $this->get("white_october_breadcrumbs");
                $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
                $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
                $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("expediente_adm_empleado_inactivo"));
                $breadcrumbs->addItem("Registrar Inactivo",  "");

                $this->get('session')->getFlashBag()->add('error','Ingrese un código de acuerdo válido para el Empleado');
                return $this->render('ExpedienteBundle:Expediente:activar.html.twig', array(          
                    'expediente' => $expedienteinfo,
                ));
            }
        }
        //si no viene con nada redirigirlo a grid de la opción
        else{
            return $this->redirect($this->generateUrl('expediente_adm_empleado_inactivo'));        
        }
    }

public function consultarEstadoAction(){

        $source = new Entity('ExpedienteBundle:Expediente','grupo_consultar_estado');
        
        $grid = $this->get('grid'); 
        
        $grid->setId('grid_consultar_estado');
        $grid->setSource($source);       

         //Columnas para filtrar
        $Nombres = new TextColumn(array('id' => 'nombres','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre','operatorsVisible'=>false));
        $grid->addColumn($Nombres,2);        
        
        // Crear
        $rowAction1 = new RowAction('Consultar', 'consultar_persona');
        $grid->addRowAction($rowAction1);

        $grid->setDefaultOrder('nombres', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Consultar estado de expediente", $this->get("router")->generate("consultar_estado"));
        
        return $grid->getGridResponse('ExpedienteBundle:Estado:consultar_estado.html.twig');   
    }

public function estadoExpedienteAction(){
    
    $request=$this->getRequest();
    $em = $this->getDoctrine()->getManager();

    $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->get('id'));
    $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteInvalido($request->get('id'));
    
     // Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
     if($expediente->getTipoexpediente() == 'I' or $expediente->getTipoexpediente() == 'A')
     {
       $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
     }
     else if($expediente->getTipoexpediente() == 'E')
     {
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_aspirante"));
     }
     else
     {
        $breadcrumbs->addItem("Empleado inactivo", $this->get("router")->generate("pantalla_empleadoactivo"));
     }
     $breadcrumbs->addItem("Consultar estado de expediente", $this->get("router")->generate("consultar_estado"));
     $breadcrumbs->addItem($expediente->getIdsolicitudempleo()->getNombrecompleto(), $this->get("router")->generate("consultar_estado"));

    return $this->render('ExpedienteBundle:Estado:estadopersona.html.twig', array(
           'tipo' => $expediente->getTipoexpediente(),
           'expediente' => $expedienteinfo,
           ));

   }

}

