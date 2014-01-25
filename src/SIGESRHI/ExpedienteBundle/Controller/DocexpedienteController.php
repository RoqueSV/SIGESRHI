<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Docexpediente;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Form\DocexpedienteType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Docexpediente controller.
 *
 */
class DocexpedienteController extends Controller
{
    /**
     * Lists all Docexpediente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Docexpediente')->findAll();

        return $this->render('ExpedienteBundle:Docexpediente:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Docexpediente entity.
     *
     */
    public function createAction(Request $request, $id)
    {
        //Si es un usuario anonimo utilizaremos el id que esta en variable de sesion desde el create de solicitud.
         $user = $this->get('security.context')->getToken()->getUser();
            if($user== "anon."){
                $anonimo = $this->getRequest()->getSession();
                $id = $anonimo->get('anonimo');
                }


        $request = $this->getRequest();
        $tipogrid = $request->query->get('tipogrid');

        $entity  = new Docexpediente();

        $entity->setFechadocexp(new \Datetime(date('d-m-Y')));
        
        //recuperamos el expediente que corresponde a id
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        $Documentos = $em->getRepository('ExpedienteBundle:Docexpediente')->findBy(array('idexpediente' => $expediente->getId()));

        //establecemos el id del expediente
        $entity->setIdexpediente($expediente);

        $form = $this->createForm(new DocexpedienteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new', 'Documento digital guardado correctamente.'); 
            return $this->redirect($this->generateUrl('docdigital_new', array(
                    'id' => $entity->getIdexpediente()->getId(),
                    'tipogrid'=> $tipogrid,)));
            
        }


        $this->get('session')->getFlashBag()->add('new_error', 'Error en el registro del documento digital.'); 
        //agregado para obtener todos los documentos digitales registrados para un expediente
        $Documentos = $em->getRepository('ExpedienteBundle:Docexpediente')->findBy(array('idexpediente' => $id));

        return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id' => $entity->getIdexpediente()->getId(),
            'expediente'=> $expediente,
            'documentos' => $Documentos,
            'tipogrid' => $tipogrid,

        ));
    }

    /**
     * Displays a form to create a new Docexpediente entity.
     *
     */
    public function newAction()
    {
        //recibimos el id del expediente creado al cual se le asociara los documentos
        $request = $this->getRequest();
        $id= $request->query->get('id');
        $tipogrid = $request->query->get('tipogrid');

        //Si es un usuario anonimo utilizaremos el id que esta en variable de sesion desde el create de solicitud.
        $user = $this->get('security.context')->getToken()->getUser();
        if($user== "anon."){
            $anonimo = $this->getRequest()->getSession();
            $id = $anonimo->get('anonimo');
        }

        $entity = new Docexpediente();
        $form   = $this->createForm(new DocexpedienteType(), $entity);

        //agregado para obtener todos los documentos digitales registrados para un expediente
        $em = $this->getDoctrine()->getManager();
        $Documentos = $em->getRepository('ExpedienteBundle:Docexpediente')->findBy(array('idexpediente' => $id));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);
        
        if (!$expediente) {
            throw $this->createNotFoundException('No es posible encontrar la entidad Expediente.');
        }

        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
               
        //tipo 1 es aspirante y consulta
        if($tipogrid==1){
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_caspirante"));
        }
        //tipo 2 es aspirante y registro
        if($tipogrid==2){
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar Documentos Digitales", $this->get("router")->generate("docdigital_raspirante"));
        }
        //tipo 3 es empleado y consulta
        if($tipogrid==3){
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_cempleado"));
        }
        //tipo 4 es empleado y registro
        if($tipogrid==4){
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar Documentos Digitales", $this->get("router")->generate("docdigital_rempleado"));
        }
        $breadcrumbs->addItem($expediente->getIdsolicitudempleo()->getnombrecompleto(), $this->get("router")->generate("docdigital_new", array('id'=>$id, 'tipogrid'=>$tipogrid)));

        
        return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id' => $id,
            'documentos' => $Documentos,
            'expediente' => $expediente,
            'tipogrid' => $tipogrid,
        ));
    }

    /**
     * Finds and displays a Docexpediente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docexpediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Docexpediente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Docexpediente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docexpediente entity.');
        }

        $editForm = $this->createForm(new DocexpedienteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Docexpediente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Docexpediente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docexpediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DocexpedienteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docdigital_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Docexpediente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Docexpediente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        $tipogrid = $request->query->get('tipogrid');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad docexpediente.');
            }
            //obtenemos el idexpediente asociado al documento que vamos eliminar
            $idexpediente= $entity->getidexpediente()->getId();

            $em->remove($entity);
            $em->flush();

            //mensaje de eliminado correctamente
            $this->get('session')->getFlashBag()->add('del', 'El documento digital se ha eliminado correctamente.'); 
            return $this->redirect($this->generateUrl('docdigital_new', array('id' => $idexpediente, 'tipogrid'=>$tipogrid)));
        }

        return $this->redirect($this->generateUrl('hello_page'));
    }

    /**
     * Creates a form to delete a Docexpediente entity by id.
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


//funcion de grid para agregar documentos digitales a un expediente (Docexpediente)
    public function RegistraDocAspirantesAction()
    {

        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar Documentos Digitales", $this->get("router")->generate("docdigital_raspirante"));


        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'I' or ".$tableAlias.".tipoexpediente = 'A'");
        }
            );

        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if($row->getField('idsolicitudempleo.numsolicitud') =="0" ){
                   $row->setField('idsolicitudempleo.numsolicitud', "N/A");                  
                }//if
                return $row;
            }
        );

        // Attach the source to the grid
        $grid->setId('grid_docdigital_aspirantes');
        $grid->setSource($source);
        
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idsolicitudempleo.numsolicitud', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'docdigital_new');

        //tipogrid 1 consultar, 2 registrar
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 2));
                return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_registrar_aspirantes.html.twig');

    }


    //funcion de grid para agregar documentos digitales a un expediente de empleado (Docexpediente)
    public function RegistraDocEmpleadosAction()
    {

        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar Documentos Digitales", $this->get("router")->generate("docdigital_raspirante"));


        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
        }
            );

         //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if($row->getField('idsolicitudempleo.numsolicitud') =="0" ){
                   $row->setField('idsolicitudempleo.numsolicitud', "N/A");                  
                }//if
                return $row;
            }
        );

        // Attach the source to the grid
        $grid->setId('grid_docdigital_empleados');
        $grid->setSource($source);
        
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idsolicitudempleo.numsolicitud', 'asc');
        
        $rowAction1 = new RowAction('Registrar', 'docdigital_new');

        //tipogrid 1 consultar, 2 registrar
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 4));
                return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_registrar_empleados.html.twig');

    }


    //funcion de grid para consultar documentos digitales de un expediente (Docexpediente)
    public function ConsultaDocAspirantesAction()
    {

        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_caspirante"));


        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'I' or ".$tableAlias.".tipoexpediente = 'A'");
        }
            );

         //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if($row->getField('idsolicitudempleo.numsolicitud') =="0" ){
                   $row->setField('idsolicitudempleo.numsolicitud', "N/A");                  
                }//if
                return $row;
            }
        );

        // Attach the source to the grid
        $grid->setId('grid_docdigital_aspirantes');
        $grid->setSource($source);
        
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idsolicitudempleo.numsolicitud', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'docdigital_new');

        //tipogrid 1 consultar, 2 registrar
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 1));
                return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_consultar_aspirantes.html.twig');

    }

//funcion de grid para agregar documentos digitales a un expediente (Docexpediente)
    public function ConsultaDocEmpleadosAction()
    {

            //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_rempleado"));

        
        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
        }
            );

         //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if($row->getField('idsolicitudempleo.numsolicitud') =="0" ){
                   $row->setField('idsolicitudempleo.numsolicitud', "N/A");                  
                }//if
                return $row;
            }
        );

        // Attach the source to the grid
        $grid->setId('grid_docdigital_empleados');
        $grid->setSource($source);
        
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idsolicitudempleo.numsolicitud', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'docdigital_new'); 

        //tipogrid 3 consultar, 4 registrar
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','tipogrid'=> 3));
                return $action;
            }
        );       
        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_consultar_empleados.html.twig');

    }

    //funcion para obtener la info de un documento digital registrado
    public function verDigitalAction($iddoc){

        
        $request = $this->getRequest();
        $tipogrid = $request->query->get('tipogrid');
        $idexp = $request->query->get('id');

        //Si es un usuario anonimo utilizaremos el id que esta en variable de sesion desde el create de solicitud.
         $user = $this->get('security.context')->getToken()->getUser();
            if($user== "anon."){
                $anonimo = $this->getRequest()->getSession();
                $idexp = $anonimo->get('anonimo');
                }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($iddoc);
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        //Si es un usuario anonimo utilizaremos el id que esta en variable de sesion desde el create de solicitud.
         $user = $this->get('security.context')->getToken()->getUser();
            if($user== "anon."){
                if($entity->getIdexpediente()->getId() != $idexp){
                    throw $this->createNotFoundException('Documento NO disponible.');
                    }
                }

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad de Documento Digital.');
        }

        ////////////////////////////////////////////////////////////////////////////////
        // INICIO CAMINO DE MIGAS
        ////////////////////////////////////////////////////////////////////////////////
            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
               
            //tipo 1 o 2 es aspirante y consulta
            if($tipogrid==1){
            $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_caspirante"));
            }

            //tipo 2 es aspirante y registro
            if($tipogrid==2){
            $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Registrar Documentos Digitales", $this->get("router")->generate("docdigital_raspirante"));
            }
       
            //tipo 3 es empleado y consulta
            if($tipogrid==3){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
            $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_cempleado"));
            }

            //tipo 4 es empleado y registro
            if($tipogrid==4){
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
            $breadcrumbs->addItem("Consultar Documentos Digitales", $this->get("router")->generate("docdigital_rempleado"));
            }

            $breadcrumbs->addItem($expediente->getIdsolicitudempleo()->getnombrecompleto(), $this->get("router")->generate("docdigital_new", array('id'=>$idexp, 'tipogrid'=>$tipogrid)));
            $breadcrumbs->addItem($entity->getnombredocexp(), $this->get("router")->generate("hello_page"));

        ////////////////////////////////////////////////////////////////////////////////
        // FIN CAMINO DE MIGAS
        ////////////////////////////////////////////////////////////////////////////////
        //extraer el formato del archivo amacenado
        $extension=substr($entity->getRutadocexp(),-3,3);

        $deleteForm = $this->createDeleteForm($iddoc);

        return $this->render('ExpedienteBundle:Docexpediente:VerDigital.html.twig', array(
            'entity'      => $entity,
            'extension' => $extension,
            'delete_form' => $deleteForm->createView(),
            'id' => $idexp,
            'tipogrid' => $tipogrid,
        ));

    }//fin function VerDigitalAction()



    public function finRegistroAspiranteAction() 
    {

        //establecemos a 0 la variable de session, asi no podra ingresar nuevamente a registrar documentos ni ver sus datos
            $user = $this->get('security.context')->getToken()->getUser();
            if($user== "anon."){
             $anonimo = $this->getRequest()->getSession();
             $anonimo->set('anonimo',0);
            }


             //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        return $this->render('ExpedienteBundle:Docexpediente:fin_registro_aspirante.html.twig');

    }// finRegistroAspirante
}
