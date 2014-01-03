<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Contratacion;
use SIGESRHI\ExpedienteBundle\Form\ContratacionType;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\AdminBundle\Entity\RefrendaAct;
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

        $source = new Entity('ExpedienteBundle:Expediente','grupo_contratacion_consultar');
        
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
                     // ->andWhere('_idempleado_idcontratacion.fechafinnom is not null')
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
        $entity->setTipocontratacion($request->get('tipo')); //1-contrato, 2-nombramiento
        
        $tipocontratacion = $request->get('tipocontratacion'); //1-aspirante, 2-empleado

        $form = $this->createForm(new ContratacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
             $em = $this->getDoctrine()->getManager();
             
             if ($tipocontratacion == 1) { //Aspirante

             //crear empleado para establecer la relación.
             $empleado = new Empleado();
             $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->get('idexpediente'));

             $empleado->setIdexpediente($expediente);
             $empleado->setCodigoempleado($request->get('codempleado'));

             $em->persist($expediente);
             
             $expediente->setTipoexpediente('E'); //Cambiar tipoexpediente
             $em->persist($empleado);
                        
             //asignamos el id del nuevo empleado
             $entity->setIdempleado($empleado);
             
             $em->persist($entity);
             $em->flush(); // Guardar cambios en BD
             
             //Actualizar RefrendaAct
             $refrendaAct = $em->getRepository('ExpedienteBundle:Contratacion')->actualizarRefrenda($entity->getPuesto(),$empleado->getId(),$empleado->getCodigoempleado());
                          
             } //Fin Aspirante

             if($tipocontratacion == 2) { //Empleado
              
             $empleado = $em->getRepository('ExpedienteBundle:Empleado')->findOneByCodigoempleado($request->get('codempleado'));
             
             //Asignamos el id del nuevo empleado
             $entity->setIdempleado($empleado);
             
             //Actualizar RefrendaAct
             $refrendaAct = $em->getRepository('ExpedienteBundle:Contratacion')->actualizarRefrenda($entity->getPuesto(),$empleado->getId(),$empleado->getCodigoempleado());
             
             $em->persist($entity);
             $em->flush(); // Guardar cambios en BD
             
             } //Fin empleado

             $this->get('session')->getFlashBag()->add('aviso', 'Contratación realizada correctamente.');
             
             if(count($entity->getIdempleado()->getIdcontratacion()) == 0){
             return $this->redirect($this->generateUrl('hojaservicio_new', array('id' => $request->get('idexpediente'),
                                                                                 'idc' => $entity->getId(),
                                                                                 'tipo'=>$tipocontratacion)));
            }
         return $this->redirect($this->generateUrl('contratacion_show', array('id' => $entity->getId(),
                                                                              'tipo'=>$tipocontratacion)));
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
        
        if ($request->get('tipogrid')==1){//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        $breadcrumbs->addItem($idexpediente->getIdsolicitudempleo()->getNumsolicitud(),  $this->get("router")->generate("contratacion_new"));
       
        return $this->render('ExpedienteBundle:Contratacion:new.html.twig', array(          
            'expediente' => $expediente,
            'tipogrid' => $request->query->get('tipogrid'), 
        ));

        }

        else{ //empleado
        // Si es empleado, obtengo las plazas que ocupa actualmente
        $query=$em->createQuery('SELECT p.nombreplaza FROM ExpedienteBundle:Expediente e
        join e.idempleado em
        join em.idrefrenda r
        join r.idplaza p
        WHERE e.id = :idexpediente'
        )->setParameter('idexpediente', $request->get('id'));
        $plazas = $query->getResult();

        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        $breadcrumbs->addItem($idexpediente->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("contratacion_new"));
      
        return $this->render('ExpedienteBundle:Contratacion:new.html.twig', array(          
            'expediente' => $expediente,
            'tipogrid' => $request->query->get('tipogrid'), // quien se contrata =  1- aspirante, 2- empleado
            'plazas' => $plazas,
        ));
        }
        
    }

    public function tipoContratoAction()
    {
        $request=$this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $tipo=$request->get('tipo'); // tipo de contratacion = 1- nombramiento, 2-contrato
        $tipocontratacion = $request->get('tipogrid'); // quien se contrata =  1- aspirante, 2- empleado

        $expediente = $em->getRepository('ExpedienteBundle:Contratacion')->obtenerAspiranteValido($request->get('idexp'));
              
        $entity = new Contratacion();
        $form = $this->createForm(new ContratacionType(), $entity);
        
        //Camino de migas
        $idexpediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('idexp'));
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        

        if ($tipocontratacion == 1) {//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        
        //Obtengo plaza para asignarla si es aspirante
        foreach ($expediente as $exp) {
          $plaza = $exp['nombreplaza'];
        }
        $idplaza = $em->getRepository('AdminBundle:Plaza')->findOneByNombreplaza($plaza);
        $idrefrenda = $em->getRepository('AdminBundle:RefrendaAct')->findOneByIdplaza($idplaza);
        $entity->setPuesto($idrefrenda); //Asignar por defecto plaza por la que optó
        
           /* Definir tipo de contratación */
           if ($tipo == 1){ //Ley de salarios
            $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_new"));
           }
           else if ($tipo == 2){ //Contrato
            $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_new"));
           }
            return $this->render('ExpedienteBundle:Contratacion:contratacion.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'tipo' => $tipo,
            'tipocontratacion'=>$tipocontratacion,
            'form' => $form->createView(),
            ));
            
        } // Fin aspirante

        else { //empleado 
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        
        //Obtengo código
        $exp = $em->getRepository('ExpedienteBundle:Expediente')->find($request->get('idexp'));
        $codigoemp = $exp->getIdempleado()->getCodigoempleado();

            
           /* Definir tipo de contratación */
           if ($tipo == 1){ //Ley de salarios
           $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_new"));
           }
           else if ($tipo == 2){ //Contrato
           $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_new"));
           }
           
           return $this->render('ExpedienteBundle:Contratacion:contratacion.html.twig', array(
           'entity' => $entity,
           'expediente' => $expediente,
           'tipo' => $tipo,
           'tipocontratacion'=>$tipocontratacion,
           'codigo' => $codigoemp,
           'form' => $form->createView(),
           ));
           
        } //fin empleado

    } //fin tipo contratación

    /**
     * Finds and displays a Contratacion entity.
     *
     */
    public function showAction($id,$tipo)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar datos de contratación", $this->get("router")->generate("contratacion_consultar"));
        $breadcrumbs->addItem($entity->getIdempleado()->getCodigoempleado(),  $this->get("router")->generate("contratacion_consultar"));

        return $this->render('ExpedienteBundle:Contratacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(), 
            'tipo' => $tipo,       ));//tipo: 1-aspirante, 2-empleado
    }

    /**
     * Displays a form to edit an existing Contratacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $request=$this->getRequest();

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }
        
        //obtener datos de puesto
        $query=$em->createQuery('SELECT c.id centro, u.id unidad, r.id puesto 
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE r.id = :puesto'
        )->setParameter('puesto', $entity->getPuesto());
        $datospuesto = $query->getResult();

        //obtener datos de puesto de jefe
        $query=$em->createQuery('SELECT c.id centrojefe, u.id unidadjefe, r.id puestojefe 
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE r.id = :puestojefe'
        )->setParameter('puestojefe', $entity->getPuestojefe());
        $puestojefe = $query->getResult();
         

        $editForm = $this->createForm(new ContratacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Contratacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'datospuesto' => $datospuesto,
            'puestojefe'  => $puestojefe,
            'tipo'        => $request->get('tipo'),
        ));
    }

    /**
     * Edits an existing Contratacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $tipo=$request->get('tipo'); // 1-aspirante, 2-empleado

        $entity = $em->getRepository('ExpedienteBundle:Contratacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contratacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContratacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
           
           $empleado= $em->getRepository('ExpedienteBundle:Empleado')->findOneByCodigoempleado($request->get('codigoactual'));

           if($tipo == 1){//Aspirante

           $empleado->setCodigoempleado($request->get('codempleado'));
           $em->persist($empleado);

           }

           if($request->get('puestoactual') != $entity->getPuesto())
           {
            $refrenda = $em->getRepository('AdminBundle:RefrendaAct')->find($request->get('puestoactual'));
            $refrenda->setIdempleado(null);
            $refrenda->setCodigoempleado(null);
            $em->persist($refrenda);
           }
           
            $em->persist($entity);
            $em->flush();

            //Actualizar RefrendaAct
            $refrendaAct = $em->getRepository('ExpedienteBundle:Contratacion')->actualizarRefrenda($entity->getPuesto(),$empleado->getId(),$empleado->getCodigoempleado());
             
            $this->get('session')->getFlashBag()->add('edit', 'Registro modificado correctamente');
            return $this->redirect($this->generateUrl('contratacion_show', array('id' => $id,'tipo'=>$tipo)));
        }

        /**** Si hay error */
        //obtener datos de puesto
        $query=$em->createQuery('SELECT c.id centro, u.id unidad, r.id puesto 
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE r.id = :puesto'
        )->setParameter('puesto', $entity->getPuesto());
        $datospuesto = $query->getResult();

        //obtener datos de puesto de jefe
        $query=$em->createQuery('SELECT c.id centrojefe, u.id unidadjefe, r.id puestojefe 
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE r.id = :puestojefe'
        )->setParameter('puestojefe', $entity->getPuestojefe());
        $puestojefe = $query->getResult();


        return $this->render('ExpedienteBundle:Contratacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'datospuesto' => $datospuesto,
            'puestojefe'  => $puestojefe,
            'tipo'        => $tipo,
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

            if($request->get('tipo') == 1 ){ //Aspirante
             $empleado=$em->getRepository('ExpedienteBundle:Empleado')->find($entity->getIdempleado());
             $expediente=$em->getRepository('ExpedienteBundle:Expediente')->find($empleado->getIdexpediente());
             $em->remove($empleado);

             $expediente->setTipoexpediente('A');
             $em->persist($expediente);

             $hojaservicio = $em->getRepository('ExpedienteBundle:Hojaservicio')->findOneByIdexpediente($expediente->getId());
             $em->remove($hojaservicio);

            }//Fin aspirante

            $refrenda = $em->getRepository('AdminBundle:RefrendaAct')->find($entity->getPuesto());
            $refrenda->setIdempleado(null);
            $refrenda->setCodigoempleado(null);
            $em->persist($refrenda);

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente');
        if($request->get('tipo') == 1 ){
        return $this->redirect($this->generateUrl('contratacion'));}
        else{
        return $this->redirect($this->generateUrl('contratacion_empleado')); 
        }
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
