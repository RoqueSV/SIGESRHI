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
            return $this->redirect($this->generateUrl('docdigital_new', array('id' => $entity->getIdexpediente()->getId())));
            /* return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'id' => $entity->getIdexpediente(),
            'form'   => $form->createView(),
            'documentos' => $Documentos,
        ));*/
        }


        $this->get('session')->getFlashBag()->add('new_error', 'Error en el registro del documento digital.'); 
        //agregado para obtener todos los documentos digitales registrados para un expediente
        $Documentos = $em->getRepository('ExpedienteBundle:Docexpediente')->findBy(array('idexpediente' => $id));

        return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id' => $entity->getIdexpediente()->getId(),
            'documentos' => $Documentos,
        ));
    }

    /**
     * Displays a form to create a new Docexpediente entity.
     *
     */
    public function newAction()
    {

        //incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));

        //recibimos el id del expediente creado al cual se le asociara los documentos
        $request = $this->getRequest();
        $id= $request->query->get('id');

        $entity = new Docexpediente();
        $form   = $this->createForm(new DocexpedienteType(), $entity);

        //agregado para obtener todos los documentos digitales registrados para un expediente
         $em = $this->getDoctrine()->getManager();
        $Documentos = $em->getRepository('ExpedienteBundle:Docexpediente')->findBy(array('idexpediente' => $id));
        //$Documentos= $em->getRepository('ExpedienteBundle:Docexpediente')->find($id);

        return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id' => $id,
            'documentos' => $Documentos
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
            return $this->redirect($this->generateUrl('docdigital_new', array('id' => $idexpediente)));
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
    public function ConsultaRegDocAspirantesAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'I' or ".$tableAlias.".tipoexpediente = 'A'");
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
        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_agregar_ver_aspirantes.html.twig');

    }


//funcion de grid para agregar documentos digitales a un expediente (Docexpediente)
    public function ConsultaRegDocEmpleadosAction()
    {
        $source = new Entity('ExpedienteBundle:Expediente', 'grupo_docdigital');
        // Get a grid instance
        $grid = $this->get('grid');


        $tableAlias=$source->getTableAlias();
        $source->manipulateQuery(
        function($query) use ($tableAlias){
            $query->andWhere($tableAlias.".tipoexpediente = 'T' or ".$tableAlias.".tipoexpediente = 'E'");
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
        $grid->addRowAction($rowAction1);     
 
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    return $grid->getGridResponse('ExpedienteBundle:Docexpediente:grid_agregar_ver_empleados.html.twig');

    }

    //funcion para obtener la info de un documento digital registrado
    public function verDigitalAction($iddoc){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docexpediente')->find($iddoc);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad de Documento Digital.');
        }

        //extraer el formato del archivo amacenado
        $extension=substr($entity->getRutadocexp(),-3,3);

        $deleteForm = $this->createDeleteForm($iddoc);

        return $this->render('ExpedienteBundle:Docexpediente:VerDigital.html.twig', array(
            'entity'      => $entity,
            'extension' => $extension,
            'delete_form' => $deleteForm->createView(),
        ));

    }//fin function VerDigitalAction()
}
