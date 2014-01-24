<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Docpersonal;
use SIGESRHI\ExpedienteBundle\Form\DocpersonalType;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column;

/**
 * Docpersonal controller.
 *
 * @Route("/docpersonal")
 */
class DocpersonalController extends Controller
{
    /**
     * Lists all Docpersonal entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo','vista_basica_expediente');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->Join($tableAlias.'.idexpediente','e')
                       ->andWhere('e.tipoexpediente = :inv')
                       ->orWhere('e.tipoexpediente = :val')
                       ->setParameter('inv','I')
                       ->setParameter('val','A');
            }
        );

        $grid->setSource($source);  
        $rowAction1 = new RowAction('Registrar', 'docpersonal_new');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action;
            }
        );
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false, "filterable" => false));
        $Nombre = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($Nombre,2);
        $grid->addColumn($plaza,3);

        $grid->setId("grid_docpersonal_aspirantes");
        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_aspirante",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Documentos Personales", $this->get("router")->generate("docpersonal"));

        return $grid->getGridResponse('ExpedienteBundle:Docpersonal:index.html.twig');
    }

    /**
     * Creates a new Docpersonal entity.
     *
     */
    public function createAction(Request $request)
    {
        $idexp=$request->get('exp');
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($idexp);
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        $Documentos = $em->getRepository('ExpedienteBundle:Docpersonal')->findBy(array(
                                                                                    'idexpediente' => $idexp,
                                                                                    ));
        $var = $request->get('nogrid');
        $nogrid = (isset($var))?0:1;

        $entity  = new Docpersonal();
        $entity->setIdexpediente($expediente);
        $indice=$this->get('request')->request->get('indice');   
        
        $entity->setentregado(1);
        
        $form = $this->createForm(new DocpersonalType(), $entity);
        $form->bind($request);
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante",array('id'=>1)));
        $breadcrumbs->addItem("Registrar Documentos Personales", $this->get("router")->generate("docpersonal"));
        $breadcrumbs->addItem($entity->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto(),"");

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new','Documento Registrado correctamente');
            return $this->redirect($this->generateUrl('docpersonal_new', array('id' => $entity->getId(), 'exp' => $idexp )));
            return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
            'nogrid' => $nogrid,
        ));
        }

        $this->get('session')->getFlashBag()->add('errornew','Errores en el Documento registrado');
        return $this->redirect($this->generateUrl('docpersonal_new', array('id' => $entity->getId(), 'exp' => $idexp )));
        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
            'nogrid' => $nogrid,
        ));
    }

    /**
     * Displays a form to create a new Docpersonal entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        $Documentos = $em->getRepository('ExpedienteBundle:Docpersonal')->findBy(array(
                                                                                    'idexpediente' => $request->query->get('exp'),
                                                                                        ));
        $var = $request->get('nogrid');

        if(isset($var)){
          $nogrid = 0;
        }
        else{
          $nogrid = 1;
        }

        $entity = new Docpersonal();
        $entity->setIdexpediente($expediente);
        
        $form   = $this->createForm(new DocpersonalType(), $entity);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_aspirante",array('id'=>1)));
        $breadcrumbs->addItem("Aspirantes", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar Documentos Personales", $this->get("router")->generate("docpersonal"));
        $breadcrumbs->addItem($entity->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto(),"");

        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
            'nogrid' => $nogrid,
        ));
    }

    /**
     * Finds and displays a Docpersonal entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Docpersonal entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $editForm = $this->createForm(new DocpersonalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Docpersonal entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $exp = $request->query->get('idexp');
        $indice = $this->get('request')->request->get('indice');
        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        //$editForm = $this->createForm(new DocpersonalType(), $entity);
        //$editForm->bind($request);
        if (is_numeric($indice) OR $indice=="") {            
            $entregado=true;
            if($indice=="" OR $indice==0){
                $indice =0;
                $entregado=false;
            }

            $entity->setIndice($indice);
            $entity->setEntregado($entregado);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new','Registro de Documentación Personal actualizada correctamente');            
            return $this->redirect($this->generateUrl('docpersonal_new', array('id' => $id,'exp' => $exp)));
        }

        $this->get('session')->getFlashBag()->add('errornew','Error en la Actualización de Documentacion Personal');
        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig',array(
            'id'      => $id,
            'exp'   => $exp,
        ));
    }

    /**
     * Deletes a Docpersonal entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $exp = $request->query->get('idexp');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            //throw $this->createNotFoundException('Unable to find Docpersonal entity.');
            $this->get('session')->getFlashBag()->add('errornew','Error al borrar el registro de Documentación Personal');            
            return $this->redirect($this->generateUrl('docpersonal_new', array('id' => $id,'exp' => $exp)));
        }

        $em->remove($entity);
        $em->flush();
    
        $this->get('session')->getFlashBag()->add('new','Registro de Documentación Personal Borrado correctamente');            
        return $this->redirect($this->generateUrl('docpersonal_new', array('id' => $id,'exp' => $exp)));
        //return $this->redirect($this->generateUrl('docpersonal'));
    }

    /**
     * Creates a form to delete a Docpersonal entity by id.
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

    //(GRID DOC PERSONAL EMPLEADO)
    public function indexEmpleadoAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente','grupo_empleado_activo');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->Join($tableAlias.'.idempleado','e')
                        //->Join('e.idcontratacion','c')                        
                        ->andWhere($tableAlias.'.tipoexpediente = :emp')
                        //->andWhere('_idempleado_fechafincontrato IS NULL')
                        ->setParameter('emp','E');
            }
        );

        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $codigo = new TextColumn(array('id' => 'codigo','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false));        
        //$plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idempleado.idcontratacion.puesto.idplaza.nombreplaza','title' => 'Plaza', 'filterable'=>false));
        $grid->addColumn($codigo,1);
        $grid->addColumn($NombreEmpleados,2);
        //$grid->addColumn($plaza,3);

        $grid->setSource($source);  
        $rowAction1 = new RowAction('Ingresar', 'docpersonal_new_empleado');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action;
            }
        );

        $grid->setId('grid_docpersonale_empleado');
        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Documentos Personales", $this->get("router")->generate("docpersonal_empleado"));

        return $grid->getGridResponse('ExpedienteBundle:Docpersonal:indexEmpleado.html.twig');
    }

        /**
     * Displays a form to create a new Docpersonal entity.(EMPLEADO)
     *
     */
    public function newEmpleadoAction()
    {
        $request = $this->getRequest();        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('id'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('id'));

        $Documentos = $em->getRepository('ExpedienteBundle:Docpersonal')->findBy(array(
                                                                                    'idexpediente' => $request->query->get('id'),
                                                                                    ));

        $var = $request->get('nogrid');

        if(isset($var)){
          $nogrid = 0;
        }
        else{
          $nogrid = 1;
        }

        $entity = new Docpersonal();
        $entity->setIdexpediente($expediente);
        $entity->setentregado(1);
        $form   = $this->createForm(new DocpersonalType(), $entity);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Documentos Personales", $this->get("router")->generate("docpersonal_empleado"));
        $breadcrumbs->addItem($expediente->getIdempleado()->getCodigoempleado(),"");        

        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
            'nogrid' => $nogrid,
        ));
    }
}
