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

/**
 * Solicitudempleo controller.
 *
 */
class SolicitudempleoController extends Controller
{
    /**
     * Lists all Solicitudempleo entities.
     *
     */
   
   /* public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Solicitudempleo')->findAll();

        return $this->render('ExpedienteBundle:Solicitudempleo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
*/

    //Metodo para establecer grid de consulta de solicitudes de empleo
    public function indexAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo', 'solicitud_empleo');
        // Get a grid instance
        $grid = $this->get('grid');

       
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

        // Attach the source to the grid
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('numsolicitud', 'asc');
        
        $rowAction1 = new RowAction('Mostrar', 'solicitud_show');
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:index.html.twig');
    }
   


    public function indexEditAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo', 'solicitud_empleo');
        // Get a grid instance
        $grid = $this->get('grid');

        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->join($tableAlias.".idexpediente ", "s")
            ->andWhere("s.tipoexpediente = 'I' ");
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

        // Attach the source to the grid
        $grid->setSource($source);


        $em = $this->getDoctrine()->getManager();
        
          
        $grid->setNoDataMessage("No se encontraron resultados");
        
        $rowAction1 = new RowAction('Modificar', 'solicitud_edit');
        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('ExpedienteBundle:Solicitudempleo:grid_editar.html.twig');
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
         $em->flush();
       
       //asignamos a solicitud el id del nuevo expediente
        $entity->setIdexpediente($expediente);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

           // return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getId())));
            $this->get('session')->getFlashBag()->add('new', 'La solicitud de empleo se ha registrado correctamente.'); 
            $this->get('session')->getFlashBag()->add('new', 'Si desea puede registrar sus documentos en formato digital en esta página.'); 
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad de Solicitud de Empleo .');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Solicitudempleo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Solicitudempleo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
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
        ));
    }

    /**
     * Edits an existing Solicitudempleo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
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
            $this->get('session')->getFlashBag()->add('show', 'Solicitud de empleo modificada correctamente'); 
            return $this->redirect($this->generateUrl('solicitud_show', array('id' => $id)));
        }

     //   return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
        $this->get('session')->getFlashBag()->add('edit', 'Ha ocurrido un error con los datos ingresados.'); 
      return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'locacion'=> $locacion,
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
    $em=$this->getDoctrine()->getEntityManager(); //agregado
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

       //$query = $em->createQuery('SELECT substring(s.numsolicitud,0,locate("-",s.numsolicitud)) correlativo, (max(COALESCE(s.numsolicitud,0))+1) numsolicitud FROM ExpedienteBundle:Solicitudempleo s');
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

}//fin clase



