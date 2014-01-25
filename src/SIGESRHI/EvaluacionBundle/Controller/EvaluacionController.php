<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Evaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\EvaluacionBundle\Entity\Respuesta;
use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Opcion;

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

        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($idrefrenda){
            $query->andWhere("_idrefrenda_puestoempleado_puestojefe.id =:var ")->setParameter('var',$idrefrenda);
             }
            );
    
  /*      $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Código',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);
*/
        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_evaluacion');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No posee subordinados registrados para este Puesto.");
        //$grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'evaluacion_new');

         $rowAction1->manipulateRender(
            function ($action, $row)use($idrefrenda)
            {
             $action->setRouteParameters(array('id','idform'=>1, 'idpuestojefe'=>$idrefrenda, 'idpuestoemp'=> $row->getField('idrefrenda.id')));
              return $action;
            }
        );

        //Editar columna del action
        /*
        $rowAction->manipulateRender(
    function ($action, $row)
    {
        if ($row->getField('quantity') == 0) {
            $action->setTitle('Sold out');
        }

        if ($row->getField('price') > 20) {
            return null;
        }

        return $action;
    }
);

$grid->addRowAction($rowAction);
*/
///editar columna de action
        
        $rowAction1->setColumn('info_column');
        $grid->addRowAction($rowAction1);     

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('EvaluacionBundle:Evaluacion:Empleados_a_evaluar.html.twig', array(
        'empleado'=>$empleado,
        'refrenda'=> $refrenda,
        ));
    }

    /**
     * Creates a new Evaluacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $numfactores = $request->get('numfactores');
        
        $evaluacion  = new Evaluacion();
        $form = $this->createForm(new EvaluacionType(), $evaluacion);
        $form->bind($request);

       
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluacion);

             for ($i=1; $i<=$numfactores; $i++){

                  $var = $request->get('respuesta-'.$i);
                
                $aux = explode("-",$var);

                echo "<br> Opcion: ".$i." : ".$aux[0]."-separador-".$aux[1];

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
     *
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
     *
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
     *
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
     *
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
     *
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

}
