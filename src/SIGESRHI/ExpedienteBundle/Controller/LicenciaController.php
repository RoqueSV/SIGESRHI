<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Licencia;
use SIGESRHI\ExpedienteBundle\Form\LicenciaType;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
/**
 * Licencia controller.
 *
 */
class LicenciaController extends Controller
{
    /**
     * Lists all Licencia entities.
     *
     */
    public function indexRegistrarAction(){    
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado');
        $grid = $this->get('grid');
        $grid->setSource($source);  

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                      ->andWhere('_idempleado_idcontratacion.fechafincontrato IS NULL')
                      ->andWhere('_idempleado_idcontratacion.fechafinnom IS NULL')
                      //->andWhere('_idempleado_idcontratacion.fechafinnom IS NULL')
                      ->setParameter('emp','E');
            }
        );        

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $codigo = new TextColumn(array('id' => 'codigo','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false));        
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idempleado.idcontratacion.puesto.idplaza.nombreplaza','title' => 'Plaza', 'filterable'=>false));
        $grid->addColumn($codigo,1);
        $grid->addColumn($NombreEmpleados,2);
        $grid->addColumn($plaza,3);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Licencias",$this->get("router")->generate("hello_page"));

        $rowAction2 = new RowAction('Registrar', 'licencia_new');
        $rowAction2->setColumn('info_column');
        $rowAction2->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','idc' => $row->getField('idempleado.idcontratacion.id') ));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction2);         

        $grid->setId('grid_licencias');
        $grid->setDefaultOrder('idempleado.codigoempleado','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('ExpedienteBundle:Licencia:index.html.twig');
    }
    public function indexVerAction(){
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado');
        $grid = $this->get('grid');
        $grid->setSource($source);  
        
        $em = $this->getDoctrine()->getManager();
        $query2 = $em->createQuery("SELECT identity(c.idempleado)
                         FROM ExpedienteBundle:Contratacion c JOIN c.idlicencia l
                         ");

        $resultado = $query2->getResult();
        $idemps=array();
        $idexp[]=0;
        if(!is_null($resultado)){
            foreach ($resultado as $val) {
                foreach ($val as $v){
                    $idemps[]=$v;
                }
            }
        }
        else{
            $idemps[]=0;
        }
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idemps){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                      ->andWhere($query->expr()->in('_idempleado_idcontratacion.idempleado', $idemps))
                        ->andWhere('_idempleado_idcontratacion.fechafincontrato IS NULL')
                        ->andWhere('_idempleado_idcontratacion.fechafinnom IS NULL')
                        //->andWhere($query->expr()->isNotNull('_idempleado_idcontratacion_idlicencia.id'))
                        ->setParameter('emp','E');
            }
        );        

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $codigo = new TextColumn(array('id' => 'codigo','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false));        
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idempleado.idcontratacion.puesto.idplaza.nombreplaza','title' => 'Plaza', 'filterable'=>false));
        $grid->addColumn($codigo,1);
        $grid->addColumn($NombreEmpleados,2);
        $grid->addColumn($plaza,3);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Licencias",$this->get("router")->generate("licencia_ver"));
        
        $rowAction1 = new RowAction('Ver Permisos', 'licencia_ver_permisos');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','idc' => $row->getField('idempleado.idcontratacion.id')));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_licencias');
        $grid->setDefaultOrder('idempleado.codigoempleado','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('ExpedienteBundle:Licencia:index.html.twig');        
    }
    /**
    * Ver grid de permisos por contrato
    */
    public function indexVerPermisosAction(Request $request,$id,$idc){
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($id,$idc);

        $source = new Entity('ExpedienteBundle:Licencia','licencias_por_contrato');
        $grid = $this->get('grid');
        $grid->setSource($source); 

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idc){
                $query->andWhere($tableAlias.'.idcontratacion = :idc')                      
                      ->setParameter('idc',$idc);
            }
        );

        $rowAction1 = new RowAction('Ver detalle', 'licencia_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row) use($idc)
            {
                $action->setRouteParameters(array('id','idc' => $idc, 'cf' => 'v'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_licencias_por_contrato');
        $grid->setDefaultOrder('fechapermiso','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Licencias",$this->get("router")->generate("licencia_ver"));
        $breadcrumbs->addItem($expedienteinfo[0]['codigoempleado'],"");   
        return $grid->getGridResponse('ExpedienteBundle:Licencia:indexlicencias.html.twig',array(
            'idc' => $idc,
            ));
    }

    public function verReporteLicenciasAction(Request $request, $idc){
        $fechainicio = $this->get('request')->request->get('fechainicio');
        $fechafin = $this->get('request')->request->get('fechafin');
        return $this->redirect($this->generateUrl('reporte_licencias',array(
            'id'=> $idc, 
            'fechainicio'=> $fechainicio, 
            'fechafin'=> $fechafin 
            )));
        //echo $idc.$fechainicio.$fechafin;
    }
   

    /**
     * Creates a new Licencia entity.
     *
     */
    public function createAction(Request $request)
    {
        $id = $request->get('id');
        $idc = $request->get('idc');
        $em = $this->getDoctrine()->getManager();
        
        $entity  = new Licencia();
        $entity -> setFechapermiso(new \Datetime(date('d-m-Y')));
        $entity -> setIdcontratacion($em->getRepository('ExpedienteBundle:Contratacion')->find($idc));

        $form = $this->createForm(new LicenciaType(), $entity);
        $form -> bind($request);
        if ($form->isValid()) {           
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('new','Permiso registrado correctamente');            
            return $this->redirect($this->generateUrl('licencia_show', array('id' => $entity->getId(), 'idc' => $entity->getidcontratacion()->getId(),'cf' => 'c' )));   
        }

        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($id,$idc);
        $plazainfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerPlazaEmpleado($idc);     

        //ver los dias y horas de permiso totales en el mes
        $fechaactual=Date('Y-m');
        $finicio=$fechaactual.'-01';
        $ffin=$fechaactual.'-31';
        $query1 = $em->createQuery('SELECT sum(l.duraciondias) tdias, sum(l.duracionhoras) thoras
                           FROM ExpedienteBundle:Licencia l
                           WHERE l.idcontratacion=:idc AND l.fechapermiso BETWEEN :fi AND :ff
                           ')
                ->setParameter('idc',$idc)
                ->setParameter('fi',$finicio)
                ->setParameter('ff',$ffin);
        $res = $query1->getResult();

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Licencias",$this->get("router")->generate("licencia_registrar"));
        $breadcrumbs->addItem($expedienteinfo[0]['codigoempleado'],"");        

        $this->get('session')->getFlashBag()->add('errornew','Errores en el Registro de Permiso');
        return $this->render('ExpedienteBundle:Licencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'expediente' => $expedienteinfo,
            'plazax' => $plazainfo,
            'totales' => $res[0],
        ));
    }

    /**
     * Displays a form to create a new Licencia entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $idc = $request->query->get('idc');
        $entity = new Licencia();
        $entity -> setFechapermiso(new \Datetime(date('d-m-Y')));
        $entity -> setIdcontratacion($em->getRepository('ExpedienteBundle:Contratacion')->find($idc));
        
        $form   = $this->createForm(new LicenciaType(), $entity);
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($id,$idc);
        $plazainfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerPlazaEmpleado($idc);
        //ver los dias y horas de permiso totales en el mes
        $fechaactual=Date('Y-m');
        $finicio=$fechaactual.'-01';
        $ffin=$fechaactual.'-31';        
        $query1 = $em->createQuery('SELECT sum(l.duraciondias) tdias, sum(l.duracionhoras) thoras
                           FROM ExpedienteBundle:Licencia l
                           WHERE l.idcontratacion=:idc AND l.fechapermiso BETWEEN :fi AND :ff
                           ')
                ->setParameter('idc',$idc)
                ->setParameter('fi',$finicio)
                ->setParameter('ff',$ffin);
        $res = $query1->getResult();
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Licencias",$this->get("router")->generate("licencia_registrar"));
        $breadcrumbs->addItem($entity->getidcontratacion()->getIdempleado()->getCodigoEmpleado(),"");
        return $this->render('ExpedienteBundle:Licencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'expediente' => $expedienteinfo,
            'plazax' => $plazainfo,
            'totales' => $res[0],
        ));
    }

    /**
     * Finds and displays a Licencia entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $idc = $request->query->get('idc');
        $comefrom = $request->query->get('cf');

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);
        //echo ($entity);
        $entityContra = $em->getRepository('ExpedienteBundle:Contratacion')->find($idc);
        $entityEmple  = $em -> getRepository('ExpedienteBundle:Empleado')->find($entityContra->getIdempleado());
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($entityEmple->getIdexpediente(),$idc);
        $plazainfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerPlazaEmpleado($idc);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo",$this->get("router")->generate("hello_page"));
        if($comefrom=='c'){            
            $breadcrumbs->addItem("Registrar Licencias",$this->get("router")->generate("licencia_registrar"));
            $breadcrumbs->addItem("Datos Registrados","");
        }
        elseif($comefrom=='v'){
            $breadcrumbs->addItem("Consultar Licencias",$this->get("router")->generate("licencia_ver"));
        }
        $breadcrumbs->addItem($expedienteinfo[0]['codigoempleado'],"");

        return $this->render('ExpedienteBundle:Licencia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'expediente' => $expedienteinfo,
            'plazax' => $plazainfo,
            'comefrom' => $comefrom,
        ));
    }

    /**
     * Displays a form to edit an existing Licencia entity.
     *
     * @Route("/{id}/edit", name="licencia_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $editForm = $this->createForm(new LicenciaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Licencia entity.
     *
     * @Route("/{id}", name="licencia_update")
     * @Method("PUT")
     * @Template("ExpedienteBundle:Licencia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LicenciaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('licencia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Licencia entity.
     *
     * @Route("/{id}", name="licencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, $cf)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Licencia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        if($cf=='c'){
            return $this->redirect($this->generateUrl('licencia_registrar'));    
        }
        else {
            return $this->redirect($this->generateUrl('licencia_ver'));
        }
    }

    /**
     * Creates a form to delete a Licencia entity by id.
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
