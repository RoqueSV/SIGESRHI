<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Accionpersonal;
use SIGESRHI\ExpedienteBundle\Entity\TipoAccion;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Form\AccionpersonalType;

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
     * Lists all Accionpersonal entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Accionpersonal')->findAll();

        return $this->render('ExpedienteBundle:Accionpersonal:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Accionpersonal entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();
        $idexp = $request->get('idexp');
        $puesto = $request->get('puesto');

        $entity  = new Accionpersonal();
        $form = $this->createForm(new AccionpersonalType(), $entity);
        $form->bind($request);

        $entity->setMotivoaccion($puesto." - ".$entity->getMotivoaccion());

        $em = $this->getDoctrine()->getManager();

        //obtenemos el objeto expediente
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
        //asignamos el id de expediente al acuerdo, mandandole el objeto de expediente
        $entity->setIdexpediente($expediente);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new', 'Accion de personal registrada correctamente.'); 
            return $this->redirect($this->generateUrl('accionpersonal_show', array('id' => $entity->getId())));
        }

         // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza
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

        //obtenemos el manejador de doctrine
        $em = $this->getDoctrine()->getManager();

        // obtenemos los puestos a los que esta asociado el empleado.
        $query = $em->createQuery('
          SELECT pl.nombreplaza
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
        ));
    }

    /**
     * Finds and displays a Accionpersonal entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Accionpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Accionpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Accionpersonal:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
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
    $em=$this->getDoctrine()->getEntityManager(); //agregado
    $TipoAccion = $em->getRepository('ExpedienteBundle:TipoAccion')->find($idTipo); //agregado
       
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
        
        $rowAction1 = new RowAction('Mostrar', 'accionpersonal_cacuerdos');
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:ConsultarEmpleadosAcuerdos.html.twig');
    }


    // Grid para consultar los acuerdos registrados de un empleado.
    public function ConsultarAcuerdosEmpleadoAction()
    {
        $request = $this->getRequest();
        $idexp = $request->get('id');

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
                $row->setField('motivoaccion', substr($row->getField('motivoaccion'),0,200)." ...");                  
                return $row;
            }
        );
       
        $grid->setId('grid_acuerdos');

        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);
          
        $grid->setNoDataMessage("No se encontraron resultados");
       // $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Mostrar', 'accionpersonal_show');
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Accionpersonal:index.html.twig', array(
        'entity'=>$entity,

        ));
    }


    //Controlador que maneja la vista de eleccion del reporte sobre acuerdos para un empleado.

    public function ElegirReporteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

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
        ));
    }


    public function LlamarReporteAction($id){

        $request = $this->getRequest();
        $idexp = $request->get('id');
        $tipo_reporte = $request->get('tipo_reporte');
        $fechainicio = $request->get('fechainicio');
        $fechafin = $request->get('fechafin');
        $tipoaccion = $request->get('tipo_accion');

        echo $tipo_reporte;
        
        if($tipo_reporte =="1"){
        return $this->redirect($this->generateUrl('solicitud_show', array('id' => $idexp)));
            }// if 1

        if($tipo_reporte =="2"){
        return $this->redirect($this->generateUrl('solicitud_show', array('id' => $idexp, 'tipo'=> $tipoaccion)));
            }// if 2
    
        if($tipo_reporte =="3"){
        return $this->redirect($this->generateUrl('solicitud_show', array('id' => $idexp, 'fechainicio'=> $fechainicio, 'fechafin'=>$fechafin)));
            }// if 3

        if($tipo_reporte =="4"){
        return $this->redirect($this->generateUrl('solicitud_show', array('id' => $idexp, 'tipo'=> $tipoaccion, 'fechainicio'=> $fechainicio, 'fechafin'=>$fechafin)));
            }// if 4

    }//function


}// fin clase
