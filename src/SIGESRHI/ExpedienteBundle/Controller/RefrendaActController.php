<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\RefrendaAct;
use SIGESRHI\ExpedienteBundle\Form\RefrendaActType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * RefrendaAct controller.
 *
 */
class RefrendaActController extends Controller
{
    /**
     * Lists all RefrendaAct entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('AdminBundle:RefrendaAct','grupo_refrenda');
        
        $grid = $this->get('grid');
        
        $grid->setId('grid_refrenda');
        $grid->setSource($source);  

        //Columnas para filtrar
        $NombrePlazas = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plazas','operatorsVisible'=>false));
        $grid->addColumn($NombrePlazas,2);           
          
        // Mostrar
        $rowAction1 = new RowAction('Consultar', 'refrendaact_show');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','tipogrid'=> 1));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setDefaultOrder('partida', 'asc');
        $grid->setLimits(array(10 => '10', 20 => '20', 30 => '30'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar puestos", "");
        
        return $grid->getGridResponse('ExpedienteBundle:RefrendaAct:index.html.twig');
    }

    /**
     * Creates a new RefrendaAct entity.
     *
     */
    public function createAction(Request $request)
    {
       
        $tipo = $request->get('tipo'); 
        $tipocontratacion = $request->get('tipocontratacion'); 
        $idexp = $request->get('idexp');

        $em = $this->getDoctrine()->getManager();

        $entity  = new RefrendaAct();

        $form = $this->createForm(new RefrendaActType(), $entity);
        $form->bind($request);

        //Asignamos nombre de plaza en RefrendaAct
        $entity->setNombreplaza($entity->getIdplaza()->getNombreplaza());

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Puesto registrado correctamente.');

            return $this->redirect($this->generateUrl('refrendaact_show', array(
                'id'     => $entity->getId(),
                'tipo'   => $tipo,
                'tipocontratacion' => $tipocontratacion,
                'idexp'  => $idexp,
                'tipogrid' => $request->get('tipogrid')
                )));
        }
 
        $this->get('session')->getFlashBag()->add('error', 'Error en el registro de datos. Repita la operación');
        return $this->render('ExpedienteBundle:RefrendaAct:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp,
            'tipogrid' => $request->get('tipogrid')
        ));
    }

    /**
     * Displays a form to create a new RefrendaAct entity.
     *
     */
    public function newAction()
    {

        $request=$this->getRequest();

        $tipo = $request->get('tipo'); // tipo de contratacion = 1- nombramiento, 2-contrato
        $tipocontratacion = $request->get('tipocontratacion'); // quien se contrata =  1- aspirante, 2- empleado
        $idexp = $request->get('idexp');

         $var = $request->get('tipogrid');
         if(isset($var)){$tipogrid=$var;}else{$tipogrid=0;}

        $entity = new RefrendaAct();
        $form   = $this->createForm(new RefrendaActType(), $entity);

        //Camino de migas
       if ($tipogrid == 2){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Nuevo puesto", $this->get("router")->generate("refrendaact"));
        }
       else{
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        if ($tipocontratacion == 1) {//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        }
        else { //empleado 
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        }
        if ($tipo == 1){ //Ley de salarios
        $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("contratacion_new"));
        }
        else if ($tipo == 2){ //Contrato
        $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("contratacion_new"));
        }
       }
        return $this->render('ExpedienteBundle:RefrendaAct:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp,
            'tipogrid' => $tipogrid
        ));
    }

    /**
     * Finds and displays a RefrendaAct entity.
     *
     */
    public function showAction($id)
    {
        $request=$this->getRequest();

        $tipo = $request->get('tipo'); 
        $tipocontratacion = $request->get('tipocontratacion'); 
        $idexp = $request->get('idexp');
        
        //tipogrid = 1: Acción consultar del grid, 2: Botón nuevo de pantalla index, 0: Nuevo puesto desde contratación
        $var = $request->get('tipogrid');
        if(isset($var)){$tipogrid=$var;}else{$tipogrid=0;}
        
        $em = $this->getDoctrine()->getManager();
   
        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
       if ($tipogrid == 1){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar puestos", $this->get("router")->generate("refrendaact"));
        $breadcrumbs->addItem("Detalle de puesto", "");
        }

       else if($tipogrid == 2){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("refrendaact_new", array('tipogrid' => 2)));
        $breadcrumbs->addItem("Datos registrados", "");
        }

       else{
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        if ($tipocontratacion == 1) {//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        }
        else { //empleado 
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        }
        if ($tipo == 1){ //Ley de salarios
        $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto / Datos registrados",  $this->get("router")->generate("contratacion_new"));
        }
        else if ($tipo == 2){ //Contrato
        $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto / Datos registrados",  $this->get("router")->generate("contratacion_new"));
        }
       }
        return $this->render('ExpedienteBundle:RefrendaAct:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),    
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp,
            'tipogrid' => $tipogrid  ));
    }

    /**
     * Displays a form to edit an existing RefrendaAct entity.
     *
     */
    public function editAction($id)
    {
        $request=$this->getRequest();

        $tipo = $request->get('tipo'); 
        $tipocontratacion = $request->get('tipocontratacion'); 
        $idexp = $request->get('idexp');
        
        //tipogrid = 1: Acción consultar del grid, 2: Botón nuevo de pantalla index, 0: Nuevo puesto desde contratación
        $var = $request->get('tipogrid');
        if(isset($var)){$tipogrid=$var;}else{$tipogrid=0;}

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        //obtener datos de unidad
        $query=$em->createQuery('SELECT c.id centro, u.id unidad
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE u.id = :unidad'
        )->setParameter('unidad', $entity->getIdunidad());
        $datosunidad = $query->getResult();

        $editForm = $this->createForm(new RefrendaActType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
      if($tipogrid == 2){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("refrendaact_new", array('tipogrid' => 2)));
        $breadcrumbs->addItem("Datos registrados", $this->get("router")->generate("refrendaact_show", array('id'=>$id,'tipogrid' => 2)));
        $breadcrumbs->addItem("Modificar", "");
        }
      else{
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        if ($tipocontratacion == 1) {//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        }
        else { //empleado 
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        }
        if ($tipo == 1){ //Ley de salarios
        $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto / Modificar datos",  $this->get("router")->generate("contratacion_new"));
        }
        else if ($tipo == 2){ //Contrato
        $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto / Modificar datos",  $this->get("router")->generate("contratacion_new"));
        }
       } 
        return $this->render('ExpedienteBundle:RefrendaAct:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'datosunidad' => $datosunidad,
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp,
            'tipogrid' => $tipogrid   ));
    }

    /**
     * Edits an existing RefrendaAct entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $tipo = $request->get('tipo'); 
        $tipocontratacion = $request->get('tipocontratacion'); 
        $idexp = $request->get('idexp');

        //tipogrid = 1: Acción consultar del grid, 2: Botón nuevo de pantalla index, 0: Nuevo puesto desde contratación
        $var = $request->get('tipogrid');
        if(isset($var)){$tipogrid=$var;}else{$tipogrid=0;}

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RefrendaActType(), $entity);
        $editForm->bind($request);

        //Asignamos nombre de plaza en RefrendaAct
        $entity->setNombreplaza($entity->getIdplaza()->getNombreplaza());

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Registro modificado correctamente.');
            return $this->redirect($this->generateUrl('refrendaact_show', array(
                'id'     => $entity->getId(),
                'tipo'   => $tipo,
                'tipocontratacion' => $tipocontratacion,
                'idexp'  => $idexp,
                'tipogrid' => $tipogrid
                )));
        }
        //Si hay error
        //obtener datos de unidad
        $query=$em->createQuery('SELECT c.id centro, u.id unidad
                                 FROM AdminBundle:RefrendaAct r
                                 join r.idunidad u
                                 join u.idcentro c
                                 WHERE u.id = :unidad'
        )->setParameter('unidad', $entity->getIdunidad());
        $datosunidad = $query->getResult();

        $this->get('session')->getFlashBag()->add('erroredit', 'Error en la modificación de datos');
        return $this->render('ExpedienteBundle:RefrendaAct:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'datosunidad' => $datosunidad,
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp'  => $idexp,
            'tipogrid' => $tipogrid
        ));
    }

    /**
     * Deletes a RefrendaAct entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        
        //tipogrid = 1: Acción consultar del grid, 2: Botón nuevo de pantalla index, 0: Nuevo puesto desde contratación
        $var = $request->get('tipogrid');
        if(isset($var)){$tipogrid=$var;}else{$tipogrid=0;}

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('error', 'Registro eliminado correctamente');

        if ($tipogrid == 2){
         return $this->redirect($this->generateUrl('refrendaact'));
        }
        else{
        return $this->redirect($this->generateUrl('contratacion_tipo',array(
               'tipo' => $request->get('tipo'), 
               'tipogrid' => $request->get('tipocontratacion'), 
               'idexp' => $request->get('idexp'),
                )));
        }
    }

    /**
     * Creates a form to delete a RefrendaAct entity by id.
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
