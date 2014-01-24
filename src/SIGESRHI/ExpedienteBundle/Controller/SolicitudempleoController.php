<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
use SIGESRHI\ExpedienteBundle\Entity\Datosempleo;
use SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares;
use SIGESRHI\ExpedienteBundle\Entity\Informacionacademica;
use SIGESRHI\ExpedienteBundle\Entity\Idioma;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Docpersonal;

use SIGESRHI\ExpedienteBundle\Entity\Municipio;
use SIGESRHI\ExpedienteBundle\Entity\Centrounidad;
use SIGESRHI\ExpedienteBundle\Entity\Departamento;
use SIGESRHI\ExpedienteBundle\Repositorio\departamentoRepository;

use SIGESRHI\ExpedienteBundle\Form\SolicitudempleoType;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Solicitudempleo controller.
 *
 */
class SolicitudempleoController extends Controller
{

    //Metodo para establecer grid de consulta de solicitudes de empleo para aspirantes.
    public function ConsultarSolicitudAspiranteAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo', 'solicitud_empleo');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Consultar Solicitud de Empleo", $this->get("router")->generate("solicitud_caspirante"));
        //fin camino de miga
       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->join($tableAlias.".idexpediente ", "s")
            ->andWhere("s.tipoexpediente = 'I' or s.tipoexpediente = 'A'" );
             }
            );

        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Invalido');                   
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                
                return $row;
            }
        );

        $NombreAspirante = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreAspirante,1);

        $PlazaAplica = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza que aplica',"operatorsVisible"=>false));
        $grid->addColumn($PlazaAplica,2);

        // Attach the source to the grid
        $grid->setId('grid_solicitud_aspirante');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('fecharegistro', 'desc');
        
        $rowAction1 = new RowAction('Consultar', 'solicitud_show');

        //vista_retorno 1 consulta de aspirantes, 2 consulta de empleados, 3 consulta de inactivos
        //4 modificar de aspirantes, 5 modificar empleados
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','vista_retorno'=> 1));
                return $action;
            }
        );

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:ConsultaSolicitudAspirante.html.twig');
    }
   

        // Grid para editar las solicitudes de los aspirantes.
    public function EditarSolicitudAspiranteAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo', 'solicitud_empleo');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Modificar Datos de Apirante", $this->get("router")->generate("solicitud_maspirante"));
        //fin camino de miga

        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->join($tableAlias.".idexpediente ", "s")
            ->andWhere("s.tipoexpediente = 'I' or s.tipoexpediente = 'A'" );
        }
            );

        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Invalido');                   
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                
                return $row;
            }
        );

       
       $NombreAspirante = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreAspirante,1);

        $PlazaAplica = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza que aplica',"operatorsVisible"=>false));
        $grid->addColumn($PlazaAplica,2);

        // Attach the source to the grid
        $grid->setId('grid_solicitud_aspirante_edit');
        $grid->setSource($source);


        //$em = $this->getDoctrine()->getManager();
        
          
        $grid->setNoDataMessage("No se encontraron resultados");

        $grid->setDefaultOrder('nombrecompleto', 'asc');
        
        $rowAction1 = new RowAction('Modificar', 'solicitud_edit');

        //vista_retorno 1 consulta de aspirantes, 2 consulta de empleados, 3 consulta de inactivos
        //4 modificar de aspirantes, 5 modificar empleados
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
             $action->setRouteParameters(array('id', 'vista_retorno'=> 4));
              return $action;
            }
        );

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:EditarSolicitudAspirante.html.twig');
    }


    /**
     * Creates a new Solicitudempleo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Solicitudempleo();
        
        //establecer fechas de creacion/modificacion (para este caso las misma)
        $entity->setFecharegistro(new \Datetime(date('d-m-Y')));
        $entity->setFechamodificacion(new \Datetime(date('d-m-Y')));
        //$entity->setnumsolicitud(8);

        $em = $this->getDoctrine()->getManager();

       //Por defecto asignamos un numero solicitud 0, ya que personal de RRHH decidira asignarle su
       //correspondiente numero de solicitud en formato correlativo/año ej.  325-2013      
        $entity->setnumsolicitud("0");

        $form = $this->createForm(new SolicitudempleoType(), $entity);
        $form->bind($request);

         //establecemos el nombre completo al campo
        $nombres= $entity->getNombres();
        $primapell= $entity->getPrimerapellido();
        $segapell= $entity->getSegundoapellido();
        $apellcasada= $entity->getApellidocasada();
        if(is_null($apellcasada)){
            $completo= $nombres." ".$primapell." ".$segapell;
        }
        else
        {
            $completo= $nombres." ".$primapell." de ".$apellcasada;
        }
    
        $entity->setNombrecompleto($completo);

       
        // Verificamos la cantidad de datos de empleo ingresados
         $numEmpleos = count($entity->getDempleos());

         if($numEmpleos > 2 ){
            $this->get('session')->getFlashBag()->add('new_error', 'Unicamente debe registrar datos de 2 empleos como máximo.'); 
            return $this->render('ExpedienteBundle:Solicitudempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
         }


        if ($form->isValid()) {

            //creamos la instancia de expediente con la cual se relacionara la solicitud.
        $expediente = new Expediente();
        $expediente->setFechaexpediente(new \datetime(date('d-m-Y')));
        $expediente->setTipoexpediente('I');

         $em->persist($expediente);
         //$em->flush();
       
       //asignamos a solicitud el id del nuevo expediente
        $entity->setIdexpediente($expediente);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            //$em->flush();
        
        //creeamos todos los docpersonal que el aspirante debera presentar.
            $documento1 = new Docpersonal(); ;$documento1->setIdexpediente($expediente); $documento1->setEntregado(false); $documento1->setNombredocpersonal('Solicitud de empleo');
            $em->persist($documento1);
            $documento2 = new Docpersonal(); $documento2->setIdexpediente($expediente); $documento2->setEntregado(false); $documento2->setNombredocpersonal('Prueba Psicológica');
            $em->persist($documento2);
            $documento3 = new Docpersonal(); $documento3->setIdexpediente($expediente); $documento3->setEntregado(false); $documento3->setNombredocpersonal('Curriculum Vitae');
            $em->persist($documento3);
            $documento4 = new Docpersonal(); $documento4->setIdexpediente($expediente); $documento4->setEntregado(false); $documento4->setNombredocpersonal('Solvencia Policia Nacional Civil');
            $em->persist($documento4);
            $documento5 = new Docpersonal(); $documento5->setIdexpediente($expediente); $documento5->setEntregado(false); $documento5->setNombredocpersonal('Fotocopia de Titulo');
            $em->persist($documento5);
            $documento6 = new Docpersonal(); $documento6->setIdexpediente($expediente); $documento6->setEntregado(false); $documento6->setNombredocpersonal('Fotocopia de Certificados');
            $em->persist($documento6);
            $documento7 = new Docpersonal(); $documento7->setIdexpediente($expediente); $documento7->setEntregado(false); $documento7->setNombredocpersonal('Fotocopia de Partida de Nacimiento');
            $em->persist($documento7);
            $documento8 = new Docpersonal(); $documento8->setIdexpediente($expediente); $documento8->setEntregado(false); $documento8->setNombredocpersonal('Fotocopia de DUI');
            $em->persist($documento8);
            $documento9 = new Docpersonal(); $documento9->setIdexpediente($expediente); $documento9->setEntregado(false); $documento9->setNombredocpersonal('Fotocopia de NIT');
            $em->persist($documento9);
            $documento10 = new Docpersonal(); $documento10->setIdexpediente($expediente); $documento10->setEntregado(false); $documento10->setNombredocpersonal('Fotocopia Número del ISSS');
            $em->persist($documento10);
            $documento11 = new Docpersonal(); $documento11->setIdexpediente($expediente); $documento11->setEntregado(false); $documento11->setNombredocpersonal('Fotocopia Número del IPSFA');
            $em->persist($documento11);
            $documento12 = new Docpersonal(); $documento12->setIdexpediente($expediente); $documento12->setEntregado(false); $documento12->setNombredocpersonal('Fotocopia Número Único de Previsión Social NUP');
            $em->persist($documento12);
            $documento13 = new Docpersonal(); $documento13->setIdexpediente($expediente); $documento13->setEntregado(false); $documento13->setNombredocpersonal('Recomendaciones Laborales');
            $em->persist($documento13);
            $documento14 = new Docpersonal(); $documento14->setIdexpediente($expediente); $documento14->setEntregado(false); $documento14->setNombredocpersonal('Recomendaciones Personales');
            $em->persist($documento14);
            $documento15 = new Docpersonal(); $documento15->setIdexpediente($expediente); $documento15->setEntregado(false); $documento15->setNombredocpersonal('Declaración de Beneficiarios');
            $em->persist($documento15);
            $documento16 = new Docpersonal(); $documento16->setIdexpediente($expediente); $documento16->setEntregado(false); $documento16->setNombredocpersonal('Declaración Jurada de Normas Técnicas de Control Interno');
            $em->persist($documento16);
            $documento17 = new Docpersonal(); $documento17->setIdexpediente($expediente); $documento17->setEntregado(false); $documento17->setNombredocpersonal('Declaración Jurada de Ética');
            $em->persist($documento17);
            $documento18 = new Docpersonal(); $documento18->setIdexpediente($expediente); $documento18->setEntregado(false); $documento18->setNombredocpersonal('Declaración Jurada que no desempeña otra plaza con el gobierno');
            $em->persist($documento18);
            $documento19 = new Docpersonal(); $documento19->setIdexpediente($expediente); $documento19->setEntregado(false); $documento19->setNombredocpersonal('Declaracion Jurada que desempeña otra plaza en el gobierno y no existe incompatibilidad de horario');
            $em->persist($documento19);
            
            /// mandamos a la base de datos todos los documentos creados
            $em->flush();
        // FIN CREACION DE DOCUMENTOS DE PERSONAL


           // return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getId())));
            $this->get('session')->getFlashBag()->add('new', 'La solicitud de empleo se ha registrado correctamente. Si desea puede registrar sus documentos en formato digital en esta página.'); 
             return $this->redirect($this->generateUrl('docdigital_new', array('id' => $expediente->getId())));
        }

        $this->get('session')->getFlashBag()->add('new_error', 'Ha ocurrido un error con los datos ingresados.'); 
        return $this->render('ExpedienteBundle:Solicitudempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Solicitudempleo entity.
     *
     */
    public function newAction()
    {
        $entity = new Solicitudempleo();
     
        //agregamos datos familiares
        $datosFam= new Datosfamiliares();
        $datosFam->name = 'Dato Familiar 1';
        $entity->getDfamiliares()->add($datosFam);
        //termina pruebas

         //agregamos datos de estudio
        $datosEst= new Informacionacademica();
        $datosEst->name = 'Dato studio 1';
        $entity->getDestudios()->add($datosEst);
        //termina pruebas
        
        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
       
        //Verificamos si se hizo búsqueda de plaza
        if(isset($_GET['id'])){
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $plaza = $em->getRepository('AdminBundle:Plaza')->find($request->get('id'));
        $entity->setIdplaza($plaza);
        $breadcrumbs->addItem("Seleccionar plaza", $this->get("router")->generate("plaza"));
        $breadcrumbs->addItem("Consultar plaza", $this->get("router")->generate("plaza_ver",array("id"=>$request->get('id'))));
        }
        $breadcrumbs->addItem("Registrar solicitud", $this->get("router")->generate("solicitud_new"));      
         
        $form   = $this->createForm(new SolicitudempleoType(), $entity);

        return $this->render('ExpedienteBundle:Solicitudempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Solicitudempleo entity.
     *
     */
    public function showAction($id)
    {
        //comprobar si viene de un grid u otra pagina (por parametro enviado)
        
        $request = $this->getRequest();
        $var = $request->get('nogrid');
        $vista_retorno = $request->get('vista_retorno');

        if(isset($var))
        {
        $nogrid=0;
        }
        else
            {
                $nogrid=1;
            }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad de Solicitud de Empleo .');
        }

        //CAMINO DE MIGA
        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        //consulta aspirante
        if($vista_retorno== 1)
        {
            $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Consultar Datos de Aspirante", $this->get("router")->generate("solicitud_caspirante"));
            $breadcrumbs->addItem($entity->getNombrecompleto(), $this->get("router")->generate("solicitud_show", array('id'=>$id)));
        }
        //consulta empleado activo
        if($vista_retorno== 2)
        {
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
            $breadcrumbs->addItem("Consultar Datos de Empleado", $this->get("router")->generate("solicitud_cempleado"));
            $breadcrumbs->addItem($entity->getIdexpediente()->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("solicitud_show", array('id'=>$id)));
        }
        //consulta empleado inactivo
        if($vista_retorno== 3)
        {
            $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
            $breadcrumbs->addItem("Consultar Datos de Empleado Inactivo", $this->get("router")->generate("solicitud_cinactivo"));
            $breadcrumbs->addItem($entity->getNombrecompleto(), $this->get("router")->generate("solicitud_show", array('id'=>$id)));
        }

        //si el show es para consulta de info desde contratacion
        if(isset($var))
        {
            if($var == 1){

                //Aspirante
                if($entity->getIdexpediente()->getTipoexpediente()=="A")
                    {
                    $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
                    $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
                    $breadcrumbs->addItem($entity->getNombrecompleto(), $this->get("router")->generate("contratacion_new",array('id'=>$entity->getIdexpediente()->getId(), 'tipogrid'=>1)));
                    }
                //empleado
                if($entity->getIdexpediente()->getTipoexpediente()=="E")
                    {
                    $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo")); 
                    $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
                    $breadcrumbs->addItem($entity->getIdexpediente()->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("contratacion_new", array('id'=>$entity->getIdexpediente()->getId(),'tipogrid'=>2)));
                    }

                $breadcrumbs->addItem("Consultar Solicitud", $this->get("router")->generate("hello_page"));
    
            }//var=1
        }//isset
        
        //fin camino de miga


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Solicitudempleo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'nogrid' =>$nogrid,
            'vista_retorno'=> $vista_retorno,      
             ));
    }

    /**
     * Displays a form to edit an existing Solicitudempleo entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $vista_retorno = $request->get('vista_retorno');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
        }

        //Camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));

        //consulta aspirante (desde show)
        if($vista_retorno== 1)
        {
            $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Consultar Datos de Aspirante", $this->get("router")->generate("solicitud_caspirante"));
            $breadcrumbs->addItem($entity->getNombrecompleto(), $this->get("router")->generate("solicitud_show", array('id'=>$id)));
            $breadcrumbs->addItem("Modificar Datos", $this->get("router")->generate("hello_page"));
        }
        //consulta empleado activo (desde show)
        if($vista_retorno== 2)
        {
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
            $breadcrumbs->addItem("Consultar Datos de Empleado", $this->get("router")->generate("solicitud_cempleado"));
            $breadcrumbs->addItem($entity->getIdexpediente()->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("solicitud_show", array('id'=>$id)));
            $breadcrumbs->addItem("Modificar Datos", $this->get("router")->generate("hello_page"));
        }
        
        //Edit para empleados inactivos NO esta disponible
        if($entity->getIdexpediente()->getTipoexpediente() == "X"){
            return $this->redirect($this->generateUrl('hello_page'));
        }
        
        //editar aspirante (desde grid)
        if($vista_retorno== 4)
        {
            $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
            $breadcrumbs->addItem("Modificar Datos de Aspirante", $this->get("router")->generate("solicitud_maspirante"));
            $breadcrumbs->addItem($entity->getNombrecompleto(), $this->get("router")->generate("solicitud_edit", array('id'=>$id, 'vista_retorno'=>$vista_retorno)));
        }
        //editar empleado (desde grid)
        if($vista_retorno== 5)
        {
            $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
            $breadcrumbs->addItem("Modificar Datos de Empleado", $this->get("router")->generate("solicitud_mempleado"));
            $breadcrumbs->addItem($entity->getIdexpediente()->getIdempleado()->getCodigoempleado(), $this->get("router")->generate("solicitud_edit", array('id'=>$id, 'vista_retorno'=>$vista_retorno)));
        }        
        

        //obtenemos el id del departamento que se registro
        $query=$em->createQuery('SELECT d.id depto, m.id muni FROM ExpedienteBundle:Municipio m
        join m.iddepartamento d
        WHERE m.id = :municipio'
        )->setParameter('municipio', $entity->getIdmunicipio());
        $locacion = $query->getResult();

        
        $editForm = $this->createForm(new SolicitudempleoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion' => $locacion,
            'vista_retorno'=> $vista_retorno,
        ));
    }

    /**
     * Edits an existing Solicitudempleo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $vista_retorno = $request->get('vista_retorno');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
        }
        $entity->setFechamodificacion(new \Datetime(date('d-m-Y')));
        
        
        // ** Para Eliminar embebidos ** //
        
        // Crea un arreglo del los objetos 'Destudios' actualmente en la base de datos
        $originalDestudios = array();
        foreach ($entity->getDestudios() as $Destudio) {
           $originalDestudios[] = $Destudio;
         }

         // Crea un arreglo del los objetos 'Dfamiliares' actualmente en la base de datos
         $originalDfamiliares = array();
        foreach ($entity->getDfamiliares() as $Dfamiliar) {
           $originalDfamiliares[] = $Dfamiliar;
         }
        
        // Crea un arreglo del los objetos 'Dempleos' actualmente en la base de datos
        $originalDempleos = array();
        foreach ($entity->getDempleos() as $Dempleo) {
           $originalDempleos[] = $Dempleo;
         }
        
        // Crea un arreglo del los objetos 'Idiomas' actualmente en la base de datos
        $originalIdiomas = array();
        foreach ($entity->getidiomas() as $Idioma) {
           $originalIdiomas[] = $Idioma;
         }

        // Fin eliminar embebidos


         //obtenemos el id del departamento que se registro
        $query=$em->createQuery('SELECT d.id depto, m.id muni FROM ExpedienteBundle:Municipio m
        join m.iddepartamento d
        WHERE m.id = :municipio'
        )->setParameter('municipio', $entity->getIdmunicipio());
        $locacion = $query->getResult();


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SolicitudempleoType(), $entity);
        $editForm->bind($request);

        //establecemos el nombre completo al campo
        $nombres= $entity->getNombres();
        $primapell= $entity->getPrimerapellido();
        $segapell= $entity->getSegundoapellido();
        $apellcasada= $entity->getApellidocasada();
        if(is_null($apellcasada)){
            $completo= $nombres." ".$primapell." ".$segapell;
        }
        else
        {
            $completo= $nombres." ".$primapell." de ".$apellcasada;
        }
    
        $entity->setNombrecompleto($completo);
        // fin establecer nombre completo

        $numEstudios=count($entity->getDestudios());
        $numFamiliares=count($entity->getDfamiliares());
        $numEmpleos = count($entity->getDempleos());

        //se valida que se ingrese por lo menos un registro de estudios
        if($numEstudios<1){
        $this->get('session')->getFlashBag()->add('erroredit', 'Debe almacenar por lo menos un dato de estudio.'); 
           // return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
            return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion'=> $locacion,
            'vista_retorno'=>$vista_retorno,
        ));

        }

        //se valida que se ingrese por lo menos un registro de  familiar
        if($numFamiliares<1){
        $this->get('session')->getFlashBag()->add('erroredit', 'Debe almacenar por lo menos los datos de un familiar'); 
            //return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
            return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion'=> $locacion,
            'vista_retorno'=>$vista_retorno,
        ));
        }

        //validamos que como mucho sean 2 registros de datos de empleo ingresados
        if($numEmpleos > 2){
        $this->get('session')->getFlashBag()->add('erroredit', 'Solo debe ingresar como máximo 2 datos de empleo.'); 
            //return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
            return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion'=> $locacion,
            'vista_retorno'=> $vista_retorno,
        ));
        }


        if ($editForm->isValid()) {

    /*   Bloque de eliminacion de los datos de Estudio. */
            foreach ($entity->getDestudios() as $Destudio) {
                foreach ($originalDestudios as $key => $toDel) {
                    if ($toDel->getId() === $Destudio->getId()) {
                        unset($originalDestudios[$key]);
                    }
                }
            }

            // Elimina la relación entre Destudio y Solicitud
            foreach ($originalDestudios as $Destudio) {
                // Si se tratara de una relación MuchosAUno, elimina la relación con esto
                 $Destudio->setIdsolicitudempleo(null);
                //Si deseas eliminar la etiqueta completamente, también lo puedes hacer
                 $em->remove($Destudio);
             }

    /* Bloque de eliminacion de los datos familiares. */
            foreach ($entity->getDfamiliares() as $Dfamiliar) {
                foreach ($originalDfamiliares as $key => $toDel) {
                    if ($toDel->getId() === $Dfamiliar->getId()) {
                        unset($originalDfamiliares[$key]);
                    }
                }
            }

            // Elimina la relación entre Dfamiliares y Solicitud
            foreach ($originalDfamiliares as $Dfamiliar) {
                // Si se tratara de una relación MuchosAUno, elimina la relación con esto
                 $Dfamiliar->setIdsolicitudempleo(null);
                //Si deseas eliminar la etiqueta completamente, también lo puedes hacer
                 $em->remove($Dfamiliar);
             }

    /* Bloque de eliminacion de los datos de empleo. */
            foreach ($entity->getDempleos() as $Dempleo) {
                foreach ($originalDempleos as $key => $toDel) {
                    if ($toDel->getId() === $Dempleo->getId()) {
                        unset($originalDempleos[$key]);
                    }
                }
            }

            // Elimina la relación entre Dempleo y Solicitud
            foreach ($originalDempleos as $Dempleo) {
                // Si se tratara de una relación MuchosAUno, elimina la relación con esto
                 $Dempleo->setIdsolicitudempleo(null);
                //Si deseas eliminar la etiqueta completamente, también lo puedes hacer
                 $em->remove($Dempleo);
             }

    /* Bloque de eliminacion de los datos de idiomas. */
            foreach ($entity->getIdiomas() as $Idioma) {
                foreach ($originalIdiomas as $key => $toDel) {
                    if ($toDel->getId() === $Idioma->getId()) {
                        unset($originalIdiomas[$key]);
                    }
                }
            }

            // Elimina la relación entre Dempleo y Solicitud
            foreach ($originalIdiomas as $Idioma) {
                // Si se tratara de una relación MuchosAUno, elimina la relación con esto
                 $Idioma->setIdsolicitudempleo(null);
                //Si deseas eliminar la etiqueta completamente, también lo puedes hacer
                 $em->remove($Idioma);
             }

            $em->persist($entity);
            $em->flush();

            if ($vista_retorno == 4 or $vista_retorno == 5){
            $this->get('session')->getFlashBag()->add('edit', 'Solicitud de empleo modificada correctamente');
            return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id, 'vista_retorno'=>$vista_retorno))); 
            }
            if($vista_retorno == 1 or $vista_retorno == 2){
            $this->get('session')->getFlashBag()->add('show', 'Solicitud de empleo modificada correctamente'); 
            return $this->redirect($this->generateUrl('solicitud_show', array('id' => $id, 'vista_retorno'=>$vista_retorno)));    
            }
            
        }//isvalid

     //   return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
        $this->get('session')->getFlashBag()->add('erroredit', 'Ha ocurrido un error con los datos ingresados.'); 
      return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion'=> $locacion,
            'vista_retorno'=> $vista_retorno,
        ));
    }

    /**
     * Deletes a Solicitudempleo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente');
        return $this->redirect($this->generateUrl('solicitud_caspirante'));
    }

    /**
     * Creates a form to delete a Solicitudempleo entity by id.
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




    /************Funcion consultar municipios**************/

 public function consultarMunicipiosJSONAction(){

    $request = $this->getRequest();
    $idDpto = $request->get('departamento');
    //$departamDao = new DepartamentoRepository($this->getDoctrine());
    //$municipios = $departamDao->consultarMunicipioDpto($idDpto);
    $em=$this->getDoctrine()->getManager(); //agregado
    $departamDao = $em->getRepository('ExpedienteBundle:Departamento')->find($idDpto); //agregado
    $municipios = $departamDao->getMunicipios();  //agregado
   
    $numfilas = count($municipios);

    $muni = new Municipio();
    $i = 0;

    foreach ($municipios as $muni){
        $rows[$i]['id'] = $muni->getId();
        $rows[$i]['cell'] = array($muni->getId(), 
            $muni->getNombremunicipio(),
            $muni->getIddepartamento());
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


public function asignarNumsolAction($id){

        $numSolicitud;
        $em = $this->getDoctrine()->getManager();
        
        //establecemos el id de la solicitud
       $query = $em->createQuery("SELECT COUNT(s.numsolicitud) AS  numsolicitud 
        FROM ExpedienteBundle:Solicitudempleo s 
        where  substring(s.numsolicitud,locate('-',s.numsolicitud)+1, 4) = :actual")
       ->setParameter('actual', date('Y'));

        $Resultado = $query->getsingleResult();

        $num=$Resultado['numsolicitud'];

        if($num==0){

            $numsolicitud="1-".date('Y');
        }
        if($num > 0){
            $num++;
            $numsolicitud = $num."-".date('Y');
        }

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        $num_anterior=$entity->getnumsolicitud();
        if($num_anterior == 0 ){
        $entity->setnumsolicitud($numsolicitud);
        $em->persist($entity);
        $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getId())));

}//fin funcion


//Metodo para establecer grid de consulta de solicitudes de empleo para Empleados.
    public function ConsultarSolicitudEmpleadoAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_solicitud_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Consultar Datos de Empleado", $this->get("router")->generate("solicitud_cempleado"));
        //fin camino de miga

       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_solicitud_empleado');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'solicitud_show');

        $rowAction1->setColumn('info_column');

        //reasignamos el id que se utilizara para la ruta (id de solicitud en vez de id de expediente)
        //vista_retorno 1 consulta de aspirantes, 2 consulta de empleados, 3 consulta de inactivos
        //4 modificar de aspirantes, 5 modificar empleados
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
             $action->setRouteParameters(array('id'=> $row->getField('idsolicitudempleo.id'),'vista_retorno'=> 2));
              return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:ConsultaSolicitudEmpleado.html.twig');
    }


    // Metodod para generar el grid de consulta de datos para Ex-Empleados
     public function ConsultarSolicitudInactivoAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_solicitud_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Inactivo", $this->get("router")->generate("pantalla_empleadoinactivo"));
        $breadcrumbs->addItem("Consultar Datos de Empleado Inactivo", $this->get("router")->generate("solicitud_cinactivo"));
        //fin camino de miga

        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'X' "); //empledos inactivos
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_solicitud_inactivo');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Mostrar', 'solicitud_show');

        $rowAction1->setColumn('info_column');

        //reasignamos el id que se utilizara para la ruta (id de solicitud en vez de id de expediente)
                //vista_retorno 1 consulta de aspirantes, 2 consulta de empleados, 3 consulta de inactivos
        //4 modificar de aspirantes, 5 modificar empleados

        $rowAction1->manipulateRender(
            function ($action, $row)
            {
             $action->setRouteParameters(array('id'=> $row->getField('idsolicitudempleo.id'), 'vista_retorno'=> 3));
              return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:ConsultaSolicitudInactivo.html.twig');
    }


    // Grid para editar las solicitudes de los empleados.
    public function EditarSolicitudEmpleadoAction()
    {
       $source = new Entity('ExpedienteBundle:Expediente', 'grupo_solicitud_empleado');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Empleado Activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Modificar Datos de Empleado", $this->get("router")->generate("solicitud_mempleado"));
        //fin camino de miga

       
          $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
             }
            );
    
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $grid->addColumn($NombreEmpleados,3);

        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','title' => 'Codigo',"operatorsVisible"=>false, 'align'=>'center'));
        $grid->addColumn($CodigoEmpleados,3);

        // Attach the source to the grid
        $grid->setId('grid_solicitud_empleado_edit');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('idempleado.codigoempleado', 'asc');
        
        $rowAction1 = new RowAction('Modificar', 'solicitud_edit');

        $rowAction1->setColumn('info_column');

        //reasignamos el id que se utilizara para la ruta (id de solicitud en vez de id de expediente)
         //vista_retorno 1 consulta de aspirantes, 2 consulta de empleados, 3 consulta de inactivos
        //4 modificar de aspirantes, 5 modificar empleados
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
             $action->setRouteParameters(array('id'=> $row->getField('idsolicitudempleo.id'), 'vista_retorno'=> 5));
              return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:EditarSolicitudEmpleado.html.twig');
    }



}//fin clase



