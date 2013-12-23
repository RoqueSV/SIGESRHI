<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Licencia;
use SIGESRHI\ExpedienteBundle\Form\LicenciaType;

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
        $grid->setNoDataMessage("No se encontraron resultados");

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                        ->andWhere('_idempleado_idcontratacion.fechafincontrato IS NULL')
                        ->setParameter('emp','E');
            }
        );        

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idempleado.idcontratacion.idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false));        
        $grid->addColumn($NombreEmpleados,1);
        $grid->addColumn($plaza,2);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleados",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Licencias",$this->get("router")->generate("hello_page"));

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
        $breadcrumbs->addItem("Registrar","");

        $grid->setId('grid_licencias');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('ExpedienteBundle:Licencia:index.html.twig');
    }
    public function indexVerAction(){
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado');
        $grid = $this->get('grid');
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :emp')
                        ->andWhere('_idempleado_idcontratacion.fechafincontrato IS NULL')
                        ->setParameter('emp','E');
            }
        );        

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idempleado.idcontratacion.idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false));        
        $grid->addColumn($NombreEmpleados,1);
        $grid->addColumn($plaza,2);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleados",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Licencias",$this->get("router")->generate("hello_page"));
        
        $rowAction1 = new RowAction('Ver', 'licencia_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','idc' => $row->getField('idempleado.idcontratacion.id') ));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);
        $breadcrumbs->addItem("Ver","");

        $grid->setId('grid_licencias');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('ExpedienteBundle:Licencia:index.html.twig');        
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
    /*  $error = 0;
        if ($form->isValid()) {            
            $periodo=$this->get('request')->request->get('periodo'); 
            if($periodo=='dias'){
                if($entity->getFechainiciolic() > $entity->getFechafinlic()){
                    $error=1;
                }
            }
            elseif ($periodo=='horas') {
                if($entity->getHorainiciolic() > $entity->getHorafinlic()){
                    $error=2;
                }
            }

            if($error==0){
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('new','Permiso registrado correctamente');            
                return $this->redirect($this->generateUrl('licencia_show', array('id' => $entity->getId())));
            }
        } */

        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($id);
        $plazasinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerPlazaEmpleado($request->query->get('idc'));        
        
        $this->get('session')->getFlashBag()->add('errornew','Errores en el Registro de Permiso');
        return $this->render('ExpedienteBundle:Licencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'expediente' => $expedienteinfo,
            'plazas' => $plazasinfo,
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
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteEmpleadoInfo($id);
        $plazasinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerPlazaEmpleado($idc);
        return $this->render('ExpedienteBundle:Licencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'expediente' => $expedienteinfo,
            'plazas' => $plazasinfo,
        ));
    }

    /**
     * Finds and displays a Licencia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Licencia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
    public function deleteAction(Request $request, $id)
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

        return $this->redirect($this->generateUrl('licencia'));
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
