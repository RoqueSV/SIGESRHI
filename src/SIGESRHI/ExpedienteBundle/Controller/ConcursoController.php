<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Concurso;
use SIGESRHI\ExpedienteBundle\Entity\Memorandum;
use SIGESRHI\AdminBundle\Entity\Plaza;
use SIGESRHI\AdminBundle\Entity\RefrendaAct;
use SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso;
use SIGESRHI\ExpedienteBundle\Form\ConcursoType;
use SIGESRHI\ExpedienteBundle\Form\MemocierreType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Concurso controller.
 *
 */
class ConcursoController extends Controller
{
    /**
     * Lists all Concurso entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('AdminBundle:Plaza','grupo_plaza');
        
        $grid = $this->get('grid');
           
        $grid->setId('grid_concurso');
        $grid->setSource($source);              
        
    
        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'concurso_new');
        $grid->addRowAction($rowAction1);
        

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
        
        return $grid->getGridResponse('ExpedienteBundle:Concurso:index.html.twig');
    }

    public function consultarAction()
    {
        $source = new Entity('ExpedienteBundle:Concurso','grupo_concurso');
        
        $grid = $this->get('grid');

        $source->manipulateRow(
          function ($row)
            {
             if ( $row->getField('fechacierre') <= new \Datetime('now') ) {
                $row->setClass('text-error');  // add a css class to the <tr> tag
                $row->setColor('#E6E8FA');  // set background-color as inline style
               }

             return $row;
            }
        );
           
        $grid->setId('grid_concurso');
        $grid->setSource($source);              
        
        $NombrePlazas = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Nombre plaza','operatorsVisible'=>false,'joinType'=>'inner'));
        $grid->addColumn($NombrePlazas,3);   

        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'detalle_concurso');
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('fechacierre', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso"));
        
        return $grid->getGridResponse('ExpedienteBundle:Concurso:index.html.twig');
    }

    /**
     * Creates a new Concurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $plaza = $em->getRepository('AdminBundle:Plaza')->find($request->get('plaza'));
        
        $entity  = new Concurso();
        $form = $this->createForm(new ConcursoType(), $entity);

        $form->bind($request);

        if ($form->isValid()) {
                    
            $entity->setIdplaza($plaza);
            $em->persist($entity);
            $em->flush();

         $this->get('session')->getFlashBag()->add('aviso', 'Concurso registrado correctamente.');

            return $this->redirect($this->generateUrl('concurso_show', array(
                'id' => $entity->getId(),
                'interesados' => $request->get('interesados'),)));
        }
        $this->get('session')->getFlashBag()->add('error', 'Error en el registro de datos.');
        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'plaza'  => $plaza,
        ));
    }

    /**
     * Displays a form to create a new Concurso entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        
        $plaza = $em->getRepository('AdminBundle:Plaza')->find($request->get('id'));
        $codigoconcurso = $this->asignarCodConcurso();

        $entity = new Concurso();

        $entity->setCodigoconcurso($codigoconcurso);
        $entity->setFechaapertura(new \Datetime(date('d-m-Y')));

        /* Fecha cierre */
        $fechaactual = date_format($entity->getFechaapertura(), 'Y-m-d');
        if( strftime("%A", strtotime($fechaactual)) == 'Monday' or strftime("%A", strtotime($fechaactual)) == 'Tuesday') 
        {
          $fechacierre = date("m/d/Y", strtotime(date('d-m-Y') ."+10 day"));  
        }
        else{
          $fechacierre = date("m/d/Y", strtotime(date('d-m-Y') ."+12 day"));  
        }

        $entity->setFechacierre(new \Datetime($fechacierre));
        /*  ----------- */
        $form   = $this->createForm(new ConcursoType(), $entity);

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
        $breadcrumbs->addItem($plaza->getNombreplaza(), $this->get("router")->generate("concurso_new"));

        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'plaza'  => $plaza,
        ));
    }

    /**
     * Finds and displays a Concurso entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
        $breadcrumbs->addItem("Datos de registro / ".$entity->getIdplaza()->getNombreplaza(), $this->get("router")->generate("concurso"));

        return $this->render('ExpedienteBundle:Concurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),  
            'interesados' => $request->get('interesados'), ));
    }


    public function detalleConcursoAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
       
        $idconcurso = $request->get('id');
       
        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }


        $source = new Entity('ExpedienteBundle:Empleadoconcurso','grupo_empleado_concurso');
        
        $grid = $this->get('grid');

         /* Resultados segun concurso */
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function($query) use ($tableAlias,$idconcurso){
                $query->andWhere('_idconcurso.id = :id')
                      ->setParameter('id',$idconcurso);
            }
        );   

        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idempleado.idexpediente.idsolicitudempleo.nombrecompleto','title' => 'Nombre','operatorsVisible'=>false, 'joinType'=>'inner'));
        $grid->addColumn($NombreEmpleados,2);
           
        $grid->setId('grid_concurso_empleado');
        $grid->setSource($source);             

        $grid->setNoDataMessage("No existen empleados que hayan aplicado al concurso");
         
        // Create an Actions Column
        $actionsColumn = new ActionsColumn('info_column_1', 'Acciones');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 4);


        // Pendiente!
        $rowAction1 = new RowAction('Ver documentación', 'concurso_new');
        $rowAction1->setColumn('info_column_1');
        $grid->addRowAction($rowAction1);

        $rowAction2 = new RowAction('Eliminar', 'empleadoconcurso_delete',true, '_self');
        $rowAction2->setConfirmMessage('¿Está seguro de eliminar este registro?');
        $rowAction2->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','idconcurso'=> $row->getField('idconcurso.id')));
                return $action;
            }
        );
        $rowAction2->setColumn('info_column_1');
        $grid->addRowAction($rowAction2);

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));       
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
        $breadcrumbs->addItem("Resultados / ".$entity->getIdplaza()->getNombreplaza(), $this->get("router")->generate("concurso"));
   
        return $grid->getGridResponse('ExpedienteBundle:Concurso:detalle_concurso.html.twig',array(
            'entity' => $entity));
    }

    /**
     * Displays a form to edit an existing Concurso entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $editForm = $this->createForm(new ConcursoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Registrar concurso interno", $this->get("router")->generate("concurso"));
        $breadcrumbs->addItem("Datos de registro", $this->get("router")->generate("concurso_show",array('id'=>$id,'interesados'=>$request->get('interesados'))));
        $breadcrumbs->addItem("Editar concurso / ".$entity->getIdplaza()->getNombreplaza(), $this->get("router")->generate("concurso"));

        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'interesados' => $request->get('interesados'),
        ));
    }

    /**
     * Edits an existing Concurso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        echo $request->get('plaza');
        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ConcursoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();
          
        $this->get('session')->getFlashBag()->add('edit', 'Registro modificado correctamente');

            return $this->redirect($this->generateUrl('concurso_show', array(
                                                      'id' => $id,
                                                      'interesados' => $request->get('interesados'),)));
        }
       
       $this->get('session')->getFlashBag()->add('erroredit', 'Error en la modificación de datos');
        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'interesados' => $request->get('interesados'),
        ));
    }

    /**
     * Deletes a Concurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Concurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente');
        return $this->redirect($this->generateUrl('concurso'));
    }

    /**
     * Creates a form to delete a Concurso entity by id.
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

    public function asignarCodConcurso(){

        $em = $this->getDoctrine()->getManager();
        
        //conocer correlativo
        $query = $em->createQuery("SELECT COUNT(c.codigoconcurso) AS  codigo 
        FROM ExpedienteBundle:Concurso c 
        where  substring(c.codigoconcurso,locate('/',c.codigoconcurso)+1, 4) = :actual")
       ->setParameter('actual', date('Y'));

        $resultado = $query->getsingleResult();

        $num=$resultado['codigo'];

        if($num==0){

            $codigo="C.I.-001/".date('Y');
        }
        if($num > 0){
            $num++;
            $codigo = "C.I.-".str_pad($num, 3, "0", STR_PAD_LEFT)."/".date('Y');
        }
        return $codigo;

    }//fin funcion

    public function generarMemorandumAction(){
        
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $idconcurso = $request->get('id');
        
        $correlativo = $this->correlMemorandum();

        if($request->get('tipo')==1){
        //Llenar memorandum
        $memorandum = new Memorandum();
        $concurso = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);
        $memorandum->setIdconcurso($concurso);
        $memorandum->setCorrelativo($correlativo);
        $memorandum->setTipomemorandum('2');

        $em->persist($memorandum);
        $em->flush();
        /* ********************* */

        return $this->redirect($this->generateUrl('reporte_memoconcurso', array(
                                                      'id' => $request->get('id'),
                                                      'correlativo' => $correlativo,
                                                      'interesados' => $request->get('interesados'),)));
        }

        else{
        
        //Verificar num de empleados que participaron en concurso
        $query=$em->createQuery('SELECT COUNT(e.id) AS numemp FROM ExpedienteBundle:Empleado e
        join e.idempleadoconcurso ec
        WHERE ec.idconcurso =:idconcurso')
        ->setParameter('idconcurso', $idconcurso);
        $resultado = $query->getSingleResult();

        $num=$resultado['numemp'];

        //Llenar memorandum
        $memorandum = new Memorandum();
        $concurso = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);
        $memorandum->setIdconcurso($concurso);
        $memorandum->setCorrelativo($correlativo);
        $memorandum->setTipomemorandum('1');

        $em->persist($memorandum);
        $em->flush();
        /* ********************* */
        /**** Persistencia del memorándum ***/
        $form = $this->createForm(new MemocierreType(), $memorandum);  
        $form->bind($request);
        //Generar memorandum
        $idempleado  = $form->get('empleado')->getData();
        $empleado    = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);
        $idhoja = $empleado->getIdexpediente()->getHojaservicio()->getId();

        /* *** Obtener titulo *** */
        $query = $em->createQuery(
                 "SELECT (case when upper(hs.educacion) like upper ('%Ingenie%') then 'Ingeniero(a)' 
                               when upper(hs.educacion) like upper ('%Licencia%') then 'Licenciado(a)' 
                               when upper(hs.educacion) like upper ('%Doctor%') then 'Doctor(a)'
                               when upper(hs.educacion) like upper ('%Profesorado%') then 'Profesor(a)'
                               else 'Sr(a).'
                               end) as titulo
                  FROM ExpedienteBundle:Hojaservicio hs 
                  WHERE hs.id =:idhoja")
                 ->setParameter('idhoja', $idhoja); 
        $resultado = $query->getSingleResult();
        $titulo=$resultado['titulo'];

        $interesado = $titulo." ".$empleado->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto();
        $cargo      = $form->get('cargo')->getData();   

        return $this->redirect($this->generateUrl('reporte_memocierre_concurso', array(
                                                      'id' => $idconcurso,
                                                      'correlativo' => $correlativo,
                                                      'interesado' => $interesado,
                                                      'cargo' => $cargo, 
                                                      'num' => $num )));
        }
    }

    public function memoCierreAction(){

      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();

      $idconcurso=$request->get('id');

      $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);

      /**** memorandum para generar el form de memocierre ****/
      $memorandum = new Memorandum();
      $form   = $this->createForm(new MemocierreType(), $memorandum);
     
     // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
        $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$idconcurso)));
        $breadcrumbs->addItem("Memorándum de cierre", $this->get("router")->generate("concurso_consultar"));
      
      return $this->render('ExpedienteBundle:Concurso:memocierre.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

     public function actaCierreAction(){

      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();

      $idconcurso=$request->get('id');

      $correlativo = $this->correlActa(); //Correlativo para el acta

      $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);

      

      //Verificar num de empleados que participaron en concurso
        $query=$em->createQuery('SELECT COUNT(e.id) AS numemp FROM ExpedienteBundle:Empleado e
        join e.idempleadoconcurso ec
        WHERE ec.idconcurso =:idconcurso')
        ->setParameter('idconcurso', $idconcurso);
        $resultado = $query->getSingleResult();

        $num=$resultado['numemp'];

        $entity->setNumeroacta($correlativo);
        $entity->setAnoacta(date('Y'));

        $em->persist($entity);
        $em->flush();
      
        return $this->redirect($this->generateUrl('reporte_actacierre_concurso', array(
                                                      'id'  => $idconcurso,
                                                      'num' => $num )));

    }


    public function correlMemorandum(){
        $em = $this->getDoctrine()->getManager();
        
        //conocer correlativo
        $query = $em->createQuery("SELECT COUNT(m.correlativo) AS  correlativo 
        FROM ExpedienteBundle:Memorandum m 
        where  substring(m.correlativo,1, 4) = :actual")
       ->setParameter('actual', date('Y'));

        $resultado = $query->getsingleResult();

        $num=$resultado['correlativo'];

        if($num==0){

            $correlativo= date('Y')."-001";
        }
        if($num > 0){
            $num++;
            $correlativo = date('Y')."-".str_pad($num, 3, "0", STR_PAD_LEFT);
        }
        return $correlativo;
    }

    public function correlActa(){
        $em = $this->getDoctrine()->getManager();
        
        //conocer correlativo
        $query = $em->createQuery("SELECT COUNT(c.numeroacta) AS  correlativo 
        FROM ExpedienteBundle:Concurso c 
        where c.numeroacta is not null");

        $resultado = $query->getsingleResult();

        $num=$resultado['correlativo'];

        if($num==0){

            $correlativo= 001;
        }
        if($num > 0){
            $num++;
            $correlativo = str_pad($num, 3, "0", STR_PAD_LEFT);
        }
        return $correlativo;
    }

        /*  Consultar cargos - Memocierre */
        public function consultarCargosJSONAction(){

        $request = $this->getRequest();
        $idEmpleado = $request->get('idempleado');
        $em=$this->getDoctrine()->getManager(); 
        $Empleado = $em->getRepository('ExpedienteBundle:Empleado')->find($idEmpleado); //agregado
        $puestos = $Empleado->getIdrefrenda();  
        $numfilas = count($puestos);

        $puesto = new RefrendaAct();
        $i = 0;

        foreach ($puestos as $puesto){
         $rows[$i]['id'] = $puesto->getId();
         $rows[$i]['cell'] = array($puesto->getId(), 
            $puesto->getNombreplaza(),
            $puesto->getIdempleado());
         $i++;
        }

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

}
