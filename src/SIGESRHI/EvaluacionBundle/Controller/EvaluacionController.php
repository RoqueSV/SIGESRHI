<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Evaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\EvaluacionBundle\Entity\Respuesta;
use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Opcion;
use SIGESRHI\EvaluacionBundle\Entity\Periodoeval;

use SIGESRHI\AdminBundle\Entity\RefrendaAct;
use Application\Sonata\UserBundle\Entity\User;

use SIGESRHI\EvaluacionBundle\Form\EvaluacionType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Evaluacion controller.
 *
 */
class EvaluacionController extends Controller
{
    /**
     * Lists all Evaluacion entities.
     *
     */
    public function EmpleadosEvaluarAction($idrefrenda)
    {
        //Obtenemos el id de empleado del usuarioo logueado
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        //validamos que el usuario este logueado
        if($user== "anon.")
        {
            throw $this->createNotFoundException('Inicie sesión para acceder a esta página');
        }
        
        //empleado >>> es el jefe (quien evaluara)
        $empleado = $user->getEmpleado();
        $idjefe = $empleado->getId();


        $em = $this->getDoctrine()->getManager();

        $jefe = $em->getRepository('ExpedienteBundle:Empleado')->find($idjefe);
        $refrenda = $em->getRepository('AdminBundle:RefrendaAct')->find($idrefrenda);
        $empleado =  $em->getRepository('ExpedienteBundle:Empleado')->find($refrenda->getIdempleado());

        //hacemos validacion de existencia de entidades, y comprobamos que el id de la refrenda sea una asignada a nuestro evaluador.
        if (!$empleado) {
            throw $this->createNotFoundException('No se encuentra la entidad del Empleado.');
        }

        if (!$refrenda) {
            throw $this->createNotFoundException('No se encuentra la entidad Refrenda del empleado.');
        }

        if (!($refrenda->getCodigoempleado() == $empleado->getCodigoempleado())) {
            throw $this->createNotFoundException('El puesto no corresponde al empleado');
        }
      
        $source = new Entity('ExpedienteBundle:Empleado', 'grupo_empleados_a_evaluar');
        // Get a grid instance
        $grid = $this->get('grid');

        //Consultamos los datos de periodo de evaluacion vigente.
        $fechaactual = date('d-m-Y');
        $periodo_query = $em->CreateQuery('
            select pe.anio, pe.semestre from EvaluacionBundle:Periodoeval pe
            where :fechaactual between pe.fechainicio and pe.fechafin
            ')->setParameter('fechaactual', $fechaactual);
        
        $periodo = $periodo_query->getsingleResult();
        //fin consulta


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($idrefrenda){
            $query->andWhere("_idrefrenda_puestoempleado_puestojefe.id =:var ")->setParameter('var',$idrefrenda);
             }
            );
    
     
        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_evaluacion');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No posee subordinados registrados para este Puesto.");
        //$grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'evaluacion_new');
        $rowAction2 = new RowAction('Consultar', 'evaluacion_show');

/* //backup
         $rowAction1->manipulateRender(
            function ($action, $row)use($idrefrenda)
            {
             $action->setRouteParameters(array('id','idform'=>1, 'idpuestojefe'=>$idrefrenda, 'idpuestoemp'=> $row->getField('idrefrenda.id')));
              return $action;
            }
        );
*/

        //Consultamos los datos de periodo de evaluacion vigente.
        $fechaactual = date('d-m-Y');
        $periodo_query = $em->CreateQuery('
            select pe.anio, pe.semestre from EvaluacionBundle:Periodoeval pe
            where :fechaactual between pe.fechainicio and pe.fechafin
            ')->setParameter('fechaactual', $fechaactual);
        
        $periodo = $periodo_query->getsingleResult();

        $periodo_evaluar= "Año: ".$periodo['anio']." - Semestre: ".$periodo['semestre'];

        //manipulamos el action de registro
         $rowAction1->manipulateRender(
            function ($action, $row)use($idrefrenda, $periodo)
            {
                if( ($periodo['anio'] == $row->getField('idevaluacion.anoevaluado') ) and $periodo['semestre']==$row->getField('idevaluacion.semestre')  ){
                   return null;
                }
                else{
                     $action->setRouteParameters(array('id','idform'=>1, 'idpuestojefe'=>$idrefrenda, 'idpuestoemp'=> $row->getField('idrefrenda.id')));
                    return $action;
                }
            }
        );

        //Manipulamos el action de consulta
        $rowAction2->manipulateRender(
            function ($action, $row)use($idrefrenda, $periodo)
            {
                if($periodo['anio'] == $row->getField('idevaluacion.anoevaluado') and $periodo['semestre']==$row->getField('idevaluacion.semestre')){
                    $action->setRouteParameters(array('id'=> $row->getField('idevaluacion.id')));
                    return $action;
                }
                else{
                    return null;
                }
            }
        );
    /*    //
         $rowAction1->manipulateRender(
            function ($action, $row)
            {
             $action->setRouteParameters(array('id'=> $row->getField('idsolicitudempleo.id'),'vista_retorno'=> 2));
              return $action;
            }
        );
      */  //
       
        $rowAction1->setColumn('info_column');
        $rowAction2->setColumn('info_column');
        $grid->addRowAction($rowAction1);     
        $grid->addRowAction($rowAction2);     
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('EvaluacionBundle:Evaluacion:Empleados_a_Evaluar.html.twig', array(
        'empleado'=>$empleado,
        'refrenda'=> $refrenda,
        'periodo_evaluar'=>$periodo_evaluar,
        ));
    }

    /**
     * Creates a new Evaluacion entity.
     */
    public function createAction(Request $request)
    {
        $numfactores = $request->get('numfactores');
        $supervisa = $request->get('supervisa');
        $comentario = $request->get('comentario');

        $evaluacion  = new Evaluacion();
        $evaluacion->setComentario($comentario);
        $evaluacion->setTiemposupervisar($supervisa);

        $form = $this->createForm(new EvaluacionType(), $evaluacion);
        $form->bind($request);

       
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluacion);

             for ($i=1; $i<=$numfactores; $i++){

                  $var = $request->get('respuesta-'.$i);
                
                $aux = explode("-",$var);

                $factor = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find((int)$aux[0]);
                $opcion = $em->getRepository('EvaluacionBundle:Opcion')->find((int)$aux[1]);
                //creamos las instancias de respuesta
                $respuesta = new Respuesta();
                $respuesta->setIdfactor($factor);
                $respuesta->setIdopcion($opcion);
                $respuesta->setIdevaluacion($evaluacion);

                $em->persist($respuesta);
                  }

            $em->flush();

            return $this->redirect($this->generateUrl('evaluacion_show', array('id' => $evaluacion->getId())));
        }

        return $this->render('EvaluacionBundle:Evaluacion:new.html.twig', array(
            'entity' => $evaluacion,
            'form'   => $form->createView(),
        ));

        
    }

    /**
     * Displays a form to create a new Evaluacion entity.
     */
    public function newAction()
    {
        //recibimos el tipo de formulario a usar
        $request = $this->getRequest();
        $form_eval = $request->get('idform');
        $idpuestoemp = $request->get('idpuestoemp');
        $idpuestojefe = $request->get('idpuestojefe');

        //Obtenemos el id de empleado del usuarioo logueado
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        //validamos que el usuario este logueado
        if($user== "anon.")
        {
            throw $this->createNotFoundException('Inicie sesión para acceder a esta página');
        }
        
        //empleado >>> es el jefe (quien evaluara)
        $empleado = $user->getEmpleado();
        $idjefe = $empleado->getId();

        $em = $this->getDoctrine()->getManager();

        $jefe = $em->getRepository('ExpedienteBundle:Empleado')->find($idjefe);
        $refrenda = $em->getRepository('AdminBundle:RefrendaAct')->find($idpuestoemp);
        $refrendajefe = $em->getRepository('AdminBundle:RefrendaAct')->find($idpuestojefe);
        $empleadoevaluado =  $em->getRepository('ExpedienteBundle:Empleado')->find($refrenda->getIdempleado());

        //hacemos validacion de existencia de entidades, y comprobamos que el id de la refrenda sea una asignada a nuestro evaluador.
        if (!$empleadoevaluado) {
            throw $this->createNotFoundException('No se encuentra la entidad del Empleado.');
        }

        if (!$refrenda) {
            throw $this->createNotFoundException('No se encuentra la entidad Refrenda del empleado.');
        }

         if (!$refrendajefe) {
            throw $this->createNotFoundException('No se encuentra la entidad Refrenda del empleado.');
        }

        if (!($refrenda->getCodigoempleado() == $empleadoevaluado->getCodigoempleado())) {
            throw $this->createNotFoundException('El puesto no corresponde al empleado');
        }
        
         $formulario = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($form_eval);

        if (!$formulario) {
          throw $this->createNotFoundException('No se puede encontrar la entidad Formulario.');
        }

        
        $evaluacion = new Evaluacion();
        $evaluacion->setFecharealizacion(new \datetime(date('d-m-Y')));
        $evaluacion->setAnoevaluado( (int)date('Y'));

        if(date('n',strtotime(date('d-m-Y')) +1 -1) < 6){
            $evaluacion->setSemestre('I');
        }
        else{
            $evaluacion->setSemestre('II');
        }
    
        $evaluacion->setPuestoemp($refrenda->getId());
        $evaluacion->setIdempleado($empleadoevaluado);
        $evaluacion->setIdJefe($jefe);
        $evaluacion->setPuestojefe($refrendajefe->getId());

        $form   = $this->createForm(new EvaluacionType(), $evaluacion);

        return $this->render('EvaluacionBundle:Evaluacion:new.html.twig', array(
            'evaluacion' => $evaluacion,
            'form'   => $form->createView(),
            'formulario'=> $formulario,
            'empleado'=> $empleadoevaluado,
            'jefe' => $jefe,
            'refrenda'=>$refrenda,
            'refrendajefe'=> $refrendajefe,
        ));
    }

    /**
     * Finds and displays a Evaluacion entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $evaluacion = $em->getRepository('EvaluacionBundle:Evaluacion')->find($id);

        if (!$evaluacion) {
            throw $this->createNotFoundException('No se puede encontrar la entidad Evaluación.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Evaluacion:show.html.twig', array(
            'evaluacion'      => $evaluacion,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Evaluacion entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Evaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evaluacion entity.');
        }

        $editForm = $this->createForm(new EvaluacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Evaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Evaluacion entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Evaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evaluacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EvaluacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evaluacion_edit', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Evaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Evaluacion entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Evaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evaluacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evaluacion'));
    }

    /**
     * Creates a form to delete a Evaluacion entity by id.
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

    public function InicioAction()
    {
        //validamos si es periodo de evaluacion.
        $periodo_evaluacion= $this->VerificarPeriodoActivo();
        if(!$periodo_evaluacion){
            return $this->redirect($this->generateUrl('evaluacion_noperiodo'));
        }        

        //Obtenemos el id de empleado del usuarioo logueado
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        
        $empleado = $user->getEmpleado();

        if(!$empleado){
            throw $this->createNotFoundException('Usuario no tiene asociado ningún perfil de empleado.');
        }

        $idempleado = $empleado->getId();


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        $numpuestos=count($entity->getIdrefrenda());


         return $this->render('EvaluacionBundle:Evaluacion:SeleccionPuesto.html.twig', array(
            'empleado'      => $entity,
            'numpuestos' => $numpuestos,
            
        ));

    }// Function Inicio


    public function VerificarPeriodoActivo(){

        $em = $this->getDoctrine()->getManager();

        $fechaactual= date('d-m-Y');
        $consulta = $em->createQuery('
            Select pe.id from EvaluacionBundle:Periodoeval pe
            where :fechaactual between pe.fechainicio and pe.fechafin
            ')->setParameter('fechaactual', $fechaactual);
        $resultado = $consulta->getResult();
        $periodo= false;
        if(count($resultado)>0){
            $periodo= true;
        }
        return $periodo;
    }// verificarperiodo()

    public function novalidoAction()
    {
        return $this->render('EvaluacionBundle:Evaluacion:noperiodo.html.twig');
    }//novalidoAction()


    //registra los comentarios y tiempo de supervisar al empleado.
    public function finalizarAction($id){

        $request = $this->getRequest();
        $incidente = $request->get('registra_incidente');

/*
        if($incidente == "SI"){
            return $this->render('EvaluacionBundle:Evaluacion:incidentes.html.twig');
        }
        if($incidente == "NO"){
            return $this->render('EvaluacionBundle:Evaluacion:SeleccionPuesto.html.twig');
        }
*/
                  return $this->redirect($this->generateUrl('evaluacion'));

    }//finalizarAction()
}
