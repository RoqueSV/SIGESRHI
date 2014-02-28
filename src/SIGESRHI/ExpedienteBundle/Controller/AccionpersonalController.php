<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Accionpersonal;
use SIGESRHI\ExpedienteBundle\Entity\TipoAccion;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Form\AccionpersonalType;
use SIGESRHI\ExpedienteBundle\Form\OtraAccionpersonalType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Accionpersonal controller.
 *
 */
class AccionpersonalController extends Controller
{
    
    /**
     * Creates a new Accionpersonal entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();
        $idexp = $request->get('idexp');

        $idrefrenda = $request->get('puesto');
        $todos_puestos= $request->get('puesto2');    

        if(isset($todos_puestos)){
            $idrefrenda=$todos_puestos;
        }
        
        $vista_retorno = $request->get('vista_retorno');

        $entity  = new Accionpersonal();
        $form = $this->createForm(new AccionpersonalType(), $entity);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();

        //obtenemos el tipo de accion a registrar
        $tipo_accion = $entity->getIdtipoaccion()->getId();
        if($tipo_accion == "5")
        {
        //verificar si ya registro las vacaciones anuales (idtipoaccion 5 segun la BD).
        $AccionPersonal = $em->createQuery('
                    SELECT ap.id
                    FROM ExpedienteBundle:Accionpersonal ap
                    join ap.idtipoaccion ta
                    WHERE  ta.id = 5 and ap.idexpediente =:idexp and ap.fecharegistroaccion between :inicioanio and :finanio'
        )->setParameter('idexp', $idexp)->setParameter('inicioanio', new \Datetime("01-01-".date('Y')))->setParameter('finanio', new \Datetime("31-12-".date('Y')));
        $ResulatadoAccionPersonal = $AccionPersonal->getResult();

            if(count($ResulatadoAccionPersonal) > 0 ){

                 //obtenemos los puestos a los que esta asociado el empleado.
                    $query = $em->createQuery('
                    SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
                    FROM ExpedienteBundle:Expediente ex
                    join ex.idempleado em
                    join em.idrefrenda re
                    join re.idplaza pl
                    WHERE ex.id =:idexp'
                    )->setParameter('idexp', $idexp);

                 $puestos = $query->getResult();
                 $this->get('session')->getFlashBag()->add('msg-error', 'Las vacaciones anuales ya se han sido registradas con anterioridad para el empleado. AÑO: '.date('Y'));
                return $this->render('ExpedienteBundle:Accionpersonal:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'idexp' =>  $idexp,
                'puestos' => $puestos,
                'vista_retorno' => $vista_retorno,
                ));

            }//Count > 0
        }//fin if tipo_accion == "5"

        //agregado para el caso que sean varias puestos a registrar el acuerdo
        if($todos_puestos=="todos"){
            $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
          FROM ExpedienteBundle:Expediente ex
          join ex.idempleado em
          join em.idrefrenda re
          join re.idplaza pl
          WHERE ex.id =:idexp'
        )->setParameter('idexp', $idexp);
        $puestos = $query->getResult();

            $motivo= $entity->getMotivoaccion();
            foreach ($puestos as $unpuesto)
            {
                $motivo= $unpuesto['nombreplaza']." - ".$motivo." - Partida: ".$unpuesto['partida']." Subpartida: ".$unpuesto['subpartida']." Sueldo Actual: $".$unpuesto['sueldoactual'];
            }
            $entity->setMotivoaccion("Acuerdo: ".$entity->getNumacuerdo()." - ".$motivo);
        }
        else
        {

           // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
          FROM AdminBundle:RefrendaAct re
          join re.idplaza pl
          WHERE re.id =:idrefrenda'
        )->setParameter('idrefrenda', $idrefrenda);

         $resultado = $query->getSingleResult();
         $puesto= "Acuerdo: ".$entity->getNumacuerdo()." - ".$resultado['nombreplaza']." ";
         $datospuesto=" Partida: ".$resultado['partida']." Subpartida: ".$resultado['subpartida']." Sueldo Actual: $".$resultado['sueldoactual'];

        $entity->setMotivoaccion($puesto." - ".$entity->getMotivoaccion()." - ".$datospuesto);
        
        }//else todos_puestos

        //si el tipo de acuerdo a registrar es 1, 2 o 3 (destitucion, renuncia o fallecimiento)
        //eliminamos la relacion entre la refrenda y el empleado.
        $tipo_accion = $entity->getIdtipoaccion()->getId(); 
        if ($tipo_accion =="1" || $tipo_accion=="2" || $tipo_accion=="3")
        {
            $refrendaact = $em->getRepository('AdminBundle:RefrendaAct')->find($idrefrenda);

            $refrendaact->setIdempleado(null);
            $em->persist($refrendaact);

            $contratacion = $em->getRepository('ExpedienteBundle:Contratacion')->findOneBy(array('puesto'=>$idrefrenda));

            //si el tipo de ontratacion es 1 (nombramiento) establecemos fecha fin del nombramiento.
            if($contratacion->getTipocontratacion()=="1")
            {
                $contratacion->setFechafinnom(new \Datetime(date('d-m-Y')));
                $em->persist($contratacion);                
            }//contratacion
            
        }//tipoaccion

        //obtenemos el objeto expediente
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
        //asignamos el id de expediente al acuerdo, mandandole el objeto de expediente
        $entity->setIdexpediente($expediente);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new', 'Accion de personal registrada correctamente.'); 
            return $this->redirect($this->generateUrl('accionpersonal_show', array(
                'id' => $entity->getId(),
                'vista_retorno'=> $vista_retorno,
            )));
        }

         // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
          FROM ExpedienteBundle:Expediente ex
          join ex.idempleado em
          join em.idrefrenda re
          join re.idplaza pl
          WHERE ex.id =:idexp'
        )->setParameter('idexp', $idexp);

         $puestos = $query->getResult();

        return $this->render('ExpedienteBundle:Accionpersonal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idexp' =>  $idexp,
            'puestos' => $puestos,
            'vista_retorno' => $vista_retorno,
        ));
    
    }

    /**
     * Displays a form to create a new Accionpersonal entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $idexp = $request->get('idexp');
        $vista_retorno = $request->get('vista_retorno');


        //obtenemos el manejador de doctrine
        $em = $this->getDoctrine()->getManager();

         $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));

        if($vista_retorno==1){
        $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cempleados"));
            }
        if($vista_retorno==2){
        $breadcrumbs->addItem("Registro de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_rempleados"));            
        }
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));
        $breadcrumbs->addItem("Nuevo Acuerdo", $this->get("router")->generate("accionpersonal_new", array('idexp'=>$idexp, 'vista_retorno'=>$vista_retorno)));            


        // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
          FROM ExpedienteBundle:Expediente ex
          join ex.idempleado em
          join em.idrefrenda re
          join re.idplaza pl
          WHERE ex.id =:idexp'
        )->setParameter('idexp', $idexp);

         $puestos = $query->getResult();

        $entity = new Accionpersonal();
        $entity->setFecharegistroaccion(new \Datetime(date('d-m-Y')));

        $form   = $this->createForm(new AccionpersonalType(), $entity);

        return $this->render('ExpedienteBundle:Accionpersonal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idexp' => $idexp,
            'puestos' => $puestos,
            'vista_retorno'=> $vista_retorno,
        ));
    }

    /**
     * Finds and displays a Accionpersonal entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        // 1 2 3 4 | 1 y2 para consultar y registrar acuerdos, 3 y 4 para consultar y registrar otras acciones
        $vista_retorno = $request->get('vista_retorno');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Accionpersonal')->find($id);
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($entity->getIdexpediente()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accionpersonal entity.');
        }

        if (!$expediente) {
            throw $this->createNotFoundException('Unable to find expediente entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        

        if($vista_retorno==1){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cempleados"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));
            }
        if($vista_retorno==2){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_rempleados"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));            
        }
        if($vista_retorno==3){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cempleadosotros"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cotrosacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));
            }
        if($vista_retorno==4){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_rempleadosotros"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cotrosacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));            
        }
        if($vista_retorno==5){
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Record Laboral", $this->get("router")->generate("accionpersonal_cinactivos"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));            
        }
        if($vista_retorno==6){
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cinactivosotros"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cotrosacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));            
        }
        $breadcrumbs->addItem("Acción de Personal", $this->get("router")->generate("accionpersonal_show", array('id'=>$id, 'vista_retorno'=>$vista_retorno)));            


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Accionpersonal:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'vista_retorno'=> $vista_retorno,
                    ));
    }

    /**
     * Displays a form to edit an existing Accionpersonal entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Accionpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accionpersonal entity.');
        }

        $editForm = $this->createForm(new AccionpersonalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Accionpersonal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Accionpersonal entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Accionpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accionpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AccionpersonalType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('accionpersonal_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Accionpersonal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Accionpersonal entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Accionpersonal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Accionpersonal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('accionpersonal'));
    }

    /**
     * Creates a form to delete a Accionpersonal entity by id.
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


     /************Funcion consultar municipios**************/

 public function ConsultarTipoAccionJSONAction(){

    $request = $this->getRequest();
    $idTipo = $request->get('idtipoaccion');
    $em=$this->getDoctrine()->getManager(); //agregado
    $TipoAccion = $em->getRepository('ExpedienteBundle:Tipoaccion')->find($idTipo); //agregado
       
    $numfilas = count($TipoAccion);

        $rows[0]['id'] = $TipoAccion->getId();
        $rows[0]['cell'] = array($TipoAccion->getDescripciontipoaccion());

    $datos = json_encode($rows);
    $pages = floor($numfilas / 10) +1;

    $jsonresponse = '{
        "page":"1",
        "total":"'.$pages.'",
        "records":"'.$numfilas.'",
        "rows":'.$datos.'}';

        $response= new Response($jsonresponse);
        return $response;
}//fin funcion


 // Grid para seleccionar el empleado a registrarle acuerdo laboral
    public function ConsultarEmpleadosAcuerdosAction()
    {
       $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Record Laboral", $this->get("router")->generate("accionpersonal_cempleados"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////


       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'accionpersonal_cacuerdos');
        //vista_retorno 1 consultar acuerdos, 2 registrar acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 1));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:ConsultarEmpleadosAcuerdos.html.twig');
    }



    // Grid para seleccionar el empleado a registrarle acuerdo laboral
    public function RegistrarEmpleadosAcuerdosAction()
    {
       $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Record Laboral", $this->get("router")->generate("accionpersonal_rempleados"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////

       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'accionpersonal_cacuerdos');
        //vista_retorno 1 consultar acuerdos, 2 registrar acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 2));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:RegistrarEmpleadosAcuerdos.html.twig');
    }


    // Grid para consultar los acuerdos registrados de un empleado.
    public function ConsultarAcuerdosEmpleadoAction()
    {
        $request = $this->getRequest();
        $idexp = $request->get('id');
        $vista_retorno = $request->get('vista_retorno');

       $source = new Entity('ExpedienteBundle:Accionpersonal', 'grupo_consultar_acuerdo');
        // Get a grid instance
        $grid = $this->get('grid');

       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias, $idexp){
            $query->andWhere("_idexpediente.id = ".$idexp)
            ->andWhere("_idtipoaccion.tipoaccion = '1'");
             }
            );
    
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if(strlen($row->getField('motivoaccion')) >= 120 ){
                   $row->setField('motivoaccion', substr($row->getField('motivoaccion'),0,120)." ...");          
                }//if
                return $row;
            }
        );
       
        $grid->setId('grid_acuerdos');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad Expediente.');
            }

        //calculamos el numero de otras acciones que tiene registrada el empleado
        $query = $em->createQuery('
          SELECT ap.id FROM ExpedienteBundle:Accionpersonal ap
          join ap.idtipoaccion ta
          WHERE ta.tipoaccion =:tipo and ap.idexpediente =:idexp'
        )->setParameter('idexp', $idexp)->setParameter('tipo', "1");  //and a.idaccesosup is null

        $numacuerdos = count($query->getResult());

         //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        

        if($vista_retorno==1){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cempleados"));
            }
        if($vista_retorno==2){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_rempleados"));            
        }
        if($vista_retorno== 5){
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
         $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cinactivos"));               
        }
        $breadcrumbs->addItem($entity->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$entity->getId(), 'vista_retorno'=>$vista_retorno)));

          
          //obtenemos el numero de puestos para los cuales el empleado tiene refrenda
          // (los puestos que ocupa)
          $numpuestos= count($entity->getIdempleado()->getIdrefrenda());

        $grid->setNoDataMessage("No se encontraron resultados");
        //$grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Mostrar', 'accionpersonal_show');

        //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row) use ($vista_retorno)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> $vista_retorno));
                return $action;
            }
        );

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:AcuerdosEmpleado.html.twig', array(
        'entity'=>$entity,
        'numpuestos'=>$numpuestos,
        'vista_retorno' => $vista_retorno,
        'numacuerdos'=>$numacuerdos,
        ));
       
    }


    //Controlador que maneja la vista de eleccion del reporte sobre acuerdos para un empleado.

    public function ElegirReporteAction($id)
    {
        $request = $this->getRequest();
        $vista_retorno = $request->get('vista_retorno');

        $em = $this->getDoctrine()->getManager();

        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        

        if($vista_retorno==1){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cempleados"));
            }
        if($vista_retorno==2){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_rempleados"));            
        }
        if($vista_retorno==5){
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Acuerdo Laboral", $this->get("router")->generate("accionpersonal_cinactivos"));            
        }
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));
        $breadcrumbs->addItem("Selección de Reporte", $this->get("router")->generate("hello_page"));
        //fin camino de miga


         $query = $em->createQuery('
            SELECT DISTINCT ta.id idtipo, ta.nombretipoaccion tipoaccion 
            from ExpedienteBundle:Accionpersonal ap
            join ap.idtipoaccion ta
            where ap.idexpediente =:idexp
            ')->setParameter('idexp',$id);
        $tipos_acuerdo = $query->getResult();

        // $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        return $this->render('ExpedienteBundle:Accionpersonal:Reporte.html.twig', array(
            'idexp'      => $id,
            'tipos_acuerdo' => $tipos_acuerdo,
            'vista_retorno'=> $vista_retorno,
        ));
    }


    public function LlamarReporteAction($id){

        $request = $this->getRequest();
        $idexp = $request->get('id');
        $tipo_reporte = $request->get('tipo_reporte');
        $fechainicio = $request->get('fechainicio');
        $fechafin = $request->get('fechafin');
        $tipoaccion = $request->get('tipo_accion');
        $vista_retorno = $request->get('vista_retorno');

        //Hoja servicio completa
        if($tipo_reporte =="1"){
        return $this->redirect($this->generateUrl('reporte_hojaservicio', array('id' => $idexp, 'vista_retorno'=>$vista_retorno)));
            }// if 1

        //Por tipo de accion
        if($tipo_reporte =="2"){
        return $this->redirect($this->generateUrl('reporte_acciones', array('id' => $idexp, 'tipo'=> $tipoaccion, 'vista_retorno'=>$vista_retorno)));
            }// if 2
    
        //Hoja de servicio filtrada por fechas
        if($tipo_reporte =="3"){
        return $this->redirect($this->generateUrl('reporte_hojaservicio', array('id' => $idexp, 'fechainicio'=> $fechainicio, 'fechafin'=>$fechafin, 'vista_retorno'=>$vista_retorno)));
            }// if 3

        //Por tipo de accion y fechas
        if($tipo_reporte =="4"){
        return $this->redirect($this->generateUrl('reporte_acciones', array('id' => $idexp, 'tipo'=> $tipoaccion, 'fechainicio'=> $fechainicio, 'fechafin'=>$fechafin, 'vista_retorno'=>$vista_retorno)));
            }// if 4

        //HOja de servicio certificada.
        if($tipo_reporte =="5"){
        return $this->redirect($this->generateUrl('reporte_certificacion', array('id' => $idexp, 'vista_retorno'=>$vista_retorno)));
            }// if 5
    }//function


/**********************************************************************************************/
///////////////////////////////  OTRAS ACCIONES DE PERSONAL ///////////////////////////////////
/*********************************************************************************************/

 // Grid para seleccionar el empleado a registrarle "otros acuerdo laboral"
    public function ConsultarEmpleadosOtrosAcuerdosAction()
    {
       $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cempleadosotros"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////


       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_otros_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Mostrar', 'accionpersonal_cotrosacuerdos');
         //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 3));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:ConsultarEmpleadosOtrosAcuerdos.html.twig');
    }


    // Grid para seleccionar el empleado a registrarle "otros acuerdo laboral"
    public function RegistrarEmpleadosOtrosAcuerdosAction()
    {
       $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_rempleadosotros"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////


       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_otros_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'accionpersonal_cotrosacuerdos');
         //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 4));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:RegistrarEmpleadosOtrosAcuerdos.html.twig');
    }



 // Grid para consultar los otros acuerdos registrados de un empleado.
    public function ConsultarOtrosAcuerdosEmpleadoAction()
    {
        $request = $this->getRequest();
        $idexp = $request->get('id');

        $vista_retorno = $request->get('vista_retorno');
       
        $source = new Entity('ExpedienteBundle:Accionpersonal', 'grupo_consultar_acuerdo');
        // Get a grid instance
        $grid = $this->get('grid');

       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias, $idexp){
            $query->andWhere("_idexpediente.id = ".$idexp)
            ->andWhere("_idtipoaccion.tipoaccion = '2'");
             }
            );
    
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if(strlen($row->getField('motivoaccion')) >= 130 ){
                   $row->setField('motivoaccion', substr($row->getField('motivoaccion'),0,130)."...");                  
                }//if
                return $row;
            }
        );
       
        $grid->setId('grid_otros_acuerdos');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

                if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad Expediente.');
                }

        //calculamos el numero de otras acciones que tiene registrada el empleado
        $query = $em->createQuery('
          SELECT ap.id FROM ExpedienteBundle:Accionpersonal ap
          join ap.idtipoaccion ta
          WHERE ta.tipoaccion =:tipo and ap.idexpediente =:idexp'
        )->setParameter('idexp', $idexp)->setParameter('tipo', "2");  //and a.idaccesosup is null

        $numacuerdos = count($query->getResult());
       
         //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        

        if($vista_retorno==3){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cempleadosotros"));
            }
        if($vista_retorno==4){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registro de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_rempleadosotros"));            
        }
        if($vista_retorno==6){
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cinactivosotros"));            
        }
        $breadcrumbs->addItem($entity->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cotrosacuerdos", array('id'=>$entity->getId(), 'vista_retorno'=>$vista_retorno)));

          //obtenemos el numero de puestos para los cuales el empleado tiene refrenda
        // (los puestos que ocupa)
          $numpuestos= count($entity->getIdempleado()->getIdrefrenda());

        $grid->setNoDataMessage("No se encontraron resultados");
       // $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        $grid->hideColumns('numacuerdo');
        
        $rowAction1 = new RowAction('Mostrar', 'accionpersonal_show');

        //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        $rowAction1->manipulateRender(
            function ($action, $row) use ($vista_retorno)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> $vista_retorno));
                return $action;
            }
        );

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:OtrosAcuerdosEmpleado.html.twig', array(
        'entity'=>$entity,
        'numpuestos'=>$numpuestos,
        'vista_retorno'=> $vista_retorno,
        'numacuerdos'=>$numacuerdos,

        ));
       
    }


    public function NuevaOtraAccionAction()
    {
        $request = $this->getRequest();
        $idexp = $request->get('idexp');
        $vista_retorno= $request->get('vista_retorno');

        //obtenemos el manejador de doctrine
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));

        if($vista_retorno==3){
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cempleadosotros"));
            }
        if($vista_retorno==4){
        $breadcrumbs->addItem("Registro de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_rempleadosotros"));            
        }
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("accionpersonal_cotrosacuerdos", array('id'=>$expediente->getId(), 'vista_retorno'=>$vista_retorno)));
        $breadcrumbs->addItem("Nueva Acción", $this->get("router")->generate("accionpersonal_new_otros", array('idexp'=>$idexp, 'vista_retorno'=>$vista_retorno)));            

        // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id
          FROM ExpedienteBundle:Expediente ex
          join ex.idempleado em
          join em.idrefrenda re
          join re.idplaza pl
          WHERE ex.id =:idexp'
        )->setParameter('idexp', $idexp);

         $puestos = $query->getResult();
        
        $entity = new Accionpersonal();
        $entity->setFecharegistroaccion(new \Datetime(date('d-m-Y')));
        

        $form   = $this->createForm(new OtraAccionpersonalType(), $entity);

        return $this->render('ExpedienteBundle:Accionpersonal:RegistraOtraAccionPersonal.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idexp' => $idexp,
            'puestos' => $puestos,
            'vista_retorno' => $vista_retorno,
        ));
    }


     public function CrearOtraAccionAction(Request $request)
    {
        $request = $this->getRequest();
        $idexp = $request->get('idexp');
        $idrefrenda = $request->get('puesto');
        $vista_retorno = $request->get('vista_retorno');

        $entity  = new Accionpersonal();
        $entity->setNumacuerdo("N/A -".substr( md5(microtime()), 1, 6));
        $form = $this->createForm(new OtraAccionpersonalType(), $entity);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();

           // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id, re.partida, re.subpartida, re.sueldoactual
          FROM AdminBundle:RefrendaAct re
          join re.idplaza pl
          WHERE re.id =:idrefrenda'
        )->setParameter('idrefrenda', $idrefrenda);

         $resultado = $query->getSingleResult();
         $puesto= $resultado['nombreplaza']." ";
         $datospuesto=" Partida: ".$resultado['partida']." Subpartida: ".$resultado['subpartida']." Sueldo Actual: $".$resultado['sueldoactual'];

        $entity->setMotivoaccion($puesto." - ".$entity->getMotivoaccion()." - ".$datospuesto);
        

        //obtenemos el objeto expediente
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
        //asignamos el id de expediente al acuerdo, mandandole el objeto de expediente
        $entity->setIdexpediente($expediente);
        
        if ($form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new', 'Accion de personal registrada correctamente.'); 
            return $this->redirect($this->generateUrl('accionpersonal_show', array(
                'id' => $entity->getId(),
                'vista_retorno' =>$vista_retorno,
                )));
        }
        
         // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza, re.id
          FROM ExpedienteBundle:Expediente ex
          join ex.idempleado em
          join em.idrefrenda re
          join re.idplaza pl
          WHERE ex.id =:idexp'
        )->setParameter('idexp', $idexp);

         $puestos = $query->getResult();
         
        return $this->render('ExpedienteBundle:Accionpersonal:RegistraOtraAccionPersonal.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idexp' =>  $idexp,
            'puestos' => $puestos,
            'vista_retorno'=> $vista_retorno,
        ));
    
    }

    public function ConsultarEmpInactivosAcuerdosAction()
    {
               $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Record Laboral", $this->get("router")->generate("accionpersonal_cinactivos"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////
       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'X'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_inactivos_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'accionpersonal_cacuerdos');
         //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        // vista_retorno 5 consultar acuerdos de emleados inactivos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 5));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:ConsultarEmpleadosInactivosAcuerdos.html.twig');
    }


    public function ConsultarEmpInactivosOtrasAccionesAction()
    {
         $source = new Entity('ExpedienteBundle:Expediente', 'grupo_acciones_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        ////////////////////////////////////////
        //Camino de miga
        ////////////////////////////////////////
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consulta de Otras Acciones de Personal", $this->get("router")->generate("accionpersonal_cinactivosotros"));

        ////////////////////////////////////////
        // Fin Camino de miga
        ////////////////////////////////////////
       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'X'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_consulta_inactivos_otros_acuerdo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'accionpersonal_cotrosacuerdos');
         //vista_retorno 3 consultar otros acuerdos, 4 registrar otros acuerdos
        // vista_retorno 5 consultar acuerdos de emleados inactivos
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 6));
                return $action;
            }
        );
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:ConsultarEmpleadosInactivosOtrosAcuerdos.html.twig');
    }

}// fin clase
