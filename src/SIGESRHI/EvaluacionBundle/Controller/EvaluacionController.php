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
use SIGESRHI\EvaluacionBundle\Entity\Incidente;

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
        
        //validamos si es periodo de evaluacion.
        $periodo_evaluacion= $this->VerificarPeriodoActivo();
        if(!$periodo_evaluacion){
            return $this->redirect($this->generateUrl('evaluacion_noperiodo'));
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

        //refrenda del jefe
        if (!$refrenda) {
            throw $this->createNotFoundException('No se encuentra la entidad Refrenda del empleado.');
        }

//        if (!($refrenda->getCodigoempleado() == $empleado->getCodigoempleado())) {
        if (!($refrenda->getCodigoempleado() == $jefe->getCodigoempleado())) {
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

        //Consultamos datos de las evaluaciones ya realizadas
        $evalhechas = $em->CreateQuery('
            select e.id, em.id idempleado, e.puestoemp, e.anoevaluado, e.semestre from EvaluacionBundle:Evaluacion e
            join e.idempleado em
            where e.anoevaluado =:anio and e.semestre =:semes and e.puestojefe =:pjefe
            ')->setParameter('anio', $periodo['anio'])->setParameter('semes',$periodo['semestre'])->setParameter('pjefe',$idrefrenda);
        
        $evaluaciones = $evalhechas->getResult();        
        //fin consulta

        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($idrefrenda, $periodo){
            $query->andWhere("_idrefrenda_puestoempleado_puestojefe.id =:var ")
            ->setParameter('var',$idrefrenda)
             ;}
            );
    
        // Attach the source to the grid
        $grid->setId('grid_consulta_empleados_evaluacion');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No posee subordinados registrados para este Puesto.");
        //$grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'evaluacion_sformulario');
        $rowAction2 = new RowAction('Consultar', 'evaluacion_show');

        //construimos el string que se mostrara como titulo en la vista de evaluacion
        $periodo_evaluar= "Año: ".$periodo['anio']." - Semestre: ".$periodo['semestre'];

        //manipulamos el action de registro
         $rowAction1->manipulateRender(
            function ($action, $row)use($idrefrenda, $evaluaciones)
            {
                $band=false;
                foreach($evaluaciones as $eval)
                {
                    if($row->getField('idrefrenda.id') == $eval['puestoemp'] and $row->getField('id') == $eval['idempleado'])
                    {
                        $band=true;
                    }

                }//foreach

                if($band == true)
                    {
                        return null;
                    }
                    else
                    {
                    $action->setRouteParameters(array('id','idpuestojefe'=>$idrefrenda, 'idpuestoemp'=> $row->getField('idrefrenda.id')));
                    return $action;
                    }
            }
        );

        //Manipulamos el action de consulta
        $rowAction2->manipulateRender(
            function ($action, $row)use($idrefrenda, $evaluaciones)
            {
                $band=false;
                $ideval=null;
                foreach($evaluaciones as $eval)
                {
                    if($row->getField('idrefrenda.id') == $eval['puestoemp'] and $row->getField('id') == $eval['idempleado'])
                    {
                        $band=true;
                        $ideval = $eval['id'];
                    }                 
                }//foreach

                if($band == true)
                 {
                    $action->setRouteParameters(array('id'=> $ideval));
                    return $action;
                }
                else{
                    return null;
                }
            }
        );
           
        $rowAction1->setColumn('info_column');
        $rowAction2->setColumn('info_column');
        $grid->addRowAction($rowAction1);     
        $grid->addRowAction($rowAction2);     
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));


         //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$idrefrenda)));
        //fin camino de miga

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
        $cargo = $request->get('cargofuncion');
        $fechacargo = $request->get('fechacargofuncion');

        $evaluacion  = new Evaluacion();
        $evaluacion->setComentario($comentario);
        $evaluacion->setTiemposupervisar($supervisa);
        $evaluacion->setCargofuncion($cargo);
        //si se ingreso fecha, la establecemos a la entidad
        //porque si viene vacio, asignaria la fecha actual.
        if($fechacargo != ""){
                $evaluacion->setFechacargofuncion(new \Datetime($fechacargo));
            }

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
        $id = $request->get('id');

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

        //Obtenemos la antiguedad del empleado para establecer el tiempo maximo de supervision que pueda tener.
        $antiguedad = $empleadoevaluado->getIdexpediente()->getHojaservicio()->getFechaingreso();
        $cant = intval((strtotime('now') - strtotime($antiguedad->format('d-m-Y')))/60/60/24/30); //meses
      echo $cant/12;
        $tiempo = array();

        
        for ($i=0;$i<=$cant;$i=$i+6){

            if($i == 0){
                $tiempo[]= "menos de 6 meses.";
            }
            else{

                if($i==6){
                    $tiempo[]= $i." meses.";
                }
                elseif($i % 12 == 0 && $i ==12){
                $tiempo[] = ($i/12)." año.";
                }
                /*elseif($i % 12 !=0 && $i <= 18){ //para establecer rangos de 6 meses
                 $tiempo[] = intval($i/12)." año y 6 meses.";   
                }*/
                elseif($i % 12 == 0 && $i > 12){
                $tiempo[] = ($i/12)." años.";
                }
               /* elseif($i % 12 !=0 && $i > 18){ //para establecer rangos de 6 meses
                 $tiempo[] = intval($i/12)." años y 6 meses.";   
                }*/


            }


           /* if($i<=6){
                $tiempo[] = "menos de 6 meses.";
            }
            elseif( $i > 6 && $i < 12)
            {
                $tiempo[] = "menos de 6 meses.";
                $tiempo[] = "6 meses.";
            }
            elseif($i == 12 ){
            $tiempo[] = ($i/12)." año.";
            
            if ($i<$cant){
                    $tiempo[] = ($i/12)." año 6 meses.";
                }
            }
            elseif($i % 12 == 0 && $i !=12){
                $tiempo[] = ($i/12)." años.";
                
            }elseif($i % 12 != 0){

                    $tiempo[] = intval($i/12)." años 6 meses.";
            } */
        }
       //fin antiguedad del empleado
        
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

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$idpuestojefe)));
        $breadcrumbs->addItem("Selección de formulario", $this->get("router")->generate("evaluacion_sformulario",array('id'=>$id, 'idpuestoemp'=>$idpuestoemp,'idpuestojefe'=>$idpuestojefe)));
        $breadcrumbs->addItem("Evaluación", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        return $this->render('EvaluacionBundle:Evaluacion:new.html.twig', array(
            'evaluacion' => $evaluacion,
            'form'   => $form->createView(),
            'formulario'=> $formulario,
            'empleado'=> $empleadoevaluado,
            'jefe' => $jefe,
            'refrenda'=>$refrenda,
            'refrendajefe'=> $refrendajefe,
            'tiempo'=>$tiempo,
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
        $puestoemp = $em->getRepository('AdminBundle:RefrendaAct')->find($evaluacion->getPuestoemp());

        if (!$puestoemp) {
            throw $this->createNotFoundException('No se puede encontrar la entidad Refrenda.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$evaluacion->getPuestojefe())));
        $breadcrumbs->addItem("Resultados Evaluación", $this->get("router")->generate("evaluacion_show",array('id'=>$id)));
        //fin camino de miga

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('EvaluacionBundle:Evaluacion:show.html.twig', array(
            'evaluacion'      => $evaluacion,
            'delete_form' => $deleteForm->createView(),
            'puestoemp'=> $puestoemp,        ));
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
        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Selección de plaza", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        //validamos si es periodo de evaluacion.
        $periodo_evaluacion= $this->VerificarPeriodoActivo();
        if(!$periodo_evaluacion){
            return $this->redirect($this->generateUrl('evaluacion_noperiodo'));
        }        

        //Obtenemos el id de empleado del usuarioo logueado
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();

        if($user == "anon."){
            throw $this->createNotFoundException('Usuario no autenticado.');
        }
        
        $empleado = $user->getEmpleado();

        if(!$empleado){
            throw $this->createNotFoundException('Usuario no tiene asociado ningún perfil de empleado.');
        }

        $idempleado = $empleado->getId();


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        $numpuestos=count($entity->getIdrefrenda());

        //Si el empleado evaluador solo posee una plaza, lo redirigimos directamente a la vista de seleccion de subordinados
        if($numpuestos = 1)
        {
            $refrenda = $entity->getIdrefrenda();
            return $this->redirect($this->generateUrl('evaluacion_seleccionempleado', array(
                'idrefrenda' => $refrenda[0]->getId(),
            )));
        }

        //si el empleado tiene mas de 1 un puesto lo mandamos a elegir el puesto con el cual desea evaluar a sus empleados
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

         $em = $this->getDoctrine()->getManager();

            //obtenemos la entidad evaluacion del empleado
            $evaluacion = $em->getRepository('EvaluacionBundle:Evaluacion')->find($id);

          if(!$evaluacion){
            throw $this->createNotFoundException('No se encontro la evaluacion del empleado.');
        }
        //obtenemos datos del empleo del empleado
        $puestoemp = $em->getRepository('AdminBundle:Refrendaact')->find($evaluacion->getPuestoemp());

          if(!$puestoemp){
            throw $this->createNotFoundException('No se encontro la plaza del empleado.');
        }
        //obtenemos datos de empleo del jefe
        $puestojefe = $em->getRepository('AdminBundle:Refrendaact')->find($evaluacion->getPuestojefe());

          if(!$puestojefe){
            throw $this->createNotFoundException('No se encontro la plaza del jefe.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$evaluacion->getPuestojefe())));
        $breadcrumbs->addItem("Resultados Evaluación", $this->get("router")->generate("evaluacion_show",array('id'=>$id)));
        $breadcrumbs->addItem("Incidentes criticos", $this->get("router")->generate("hello_page"));
        //fin camino de miga

            return $this->render('EvaluacionBundle:Evaluacion:incidentes.html.twig', array(
                'evaluacion' => $evaluacion,
                'puestoemp' => $puestoemp,
                'puestojefe' => $puestojefe,
                ));
        
    }//finalizarAction()


    public function SeleccionFormularioAction($id, $idpuestoemp, $idpuestojefe){

        $em = $this->getDoctrine()->getManager();

         $puestoemp = $em->getRepository('AdminBundle:RefrendaAct')->find($idpuestoemp);

          if(!$puestoemp){
            throw $this->createNotFoundException('No se encontro la refrenda del empleado.');
        }

        $formularios = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->findBy(array('estadoform'=>'A'));

         if(!$formularios){
            throw $this->createNotFoundException('No hay formularios registrados en el sistema.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Realizar evaluación", $this->get("router")->generate("evaluacion_seleccionempleado", array('idrefrenda'=>$idpuestojefe)));
        $breadcrumbs->addItem("Selección de formulario", $this->get("router")->generate("evaluacion_sformulario",array('id'=>$id, 'idpuestoemp'=>$idpuestoemp,'idpuestojefe'=>$idpuestojefe)));
//        $breadcrumbs->addItem("Incidentes criticos", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        return $this->render('EvaluacionBundle:Evaluacion:SeleccionFormulario.html.twig', 
            array(
                'formularios'=>$formularios,
                'puestoemp'=>$puestoemp,
                'id'=>$id,
                'idpuestoemp'=>$idpuestoemp,
                'idpuestojefe'=>$idpuestojefe,
                ));
    }// SeleccionFormulario

    public function LlamarFormularioAction($id, $idpuestoemp, $idpuestojefe)
    {
        $request = $this->getRequest();
        $idform = $request->get('tipo_form');

        return $this->redirect($this->generateUrl('evaluacion_new',array('idform'=>$idform, 'id'=>$id, 'idpuestoemp'=>$idpuestoemp,'idpuestojefe'=>$idpuestojefe)));

    }//LlamarFormulario

    public function RegistraIncidenteAction($idevaluacion)
    {
        $request = $this->getRequest();
        //recuperamos los parametros del formulario de incidentes
        $fecha = $request->get('fecha');
        $idfactor = $request->get('factor');
        $tipo_incidente = $request->get('tipoincidente');
        $descripcion = $request->get('descripcionincidente');
        $observacion = $request->get('observaciones');

        $em = $this->getDoctrine()->getManager();

        $evaluacion = $em->getRepository('EvaluacionBundle:Evaluacion')->find($idevaluacion);

          if(!$evaluacion){
            throw $this->createNotFoundException('No se encontro la evaluación del empleado.');
        }

        $evaluacion->setObservacion($observacion);
        $em->persist($evaluacion);

        $factor_evaluacion = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($idfactor);

          if(!$factor_evaluacion){
            throw $this->createNotFoundException('No se encontro el factor de evaluación.');
        }

        $incidente = new Incidente();
        $incidente->setIdevaluacion($evaluacion);
        $incidente->setIdfactorevaluacion($factor_evaluacion);
        $incidente->setFechaincidente(new \Datetime($fecha));
        $incidente->setTipoincidente($tipo_incidente);
        $incidente->setDescripcionincidente($descripcion);
        $em->persist($incidente);
        $em->flush();

        return $this->redirect($this->generateUrl('evaluacion_finaliza',array('id'=>$evaluacion->getId())));

    }//RegistraIncidente()
}
