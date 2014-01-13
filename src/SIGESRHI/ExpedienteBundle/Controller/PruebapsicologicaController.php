<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Repositorio\ExpedienteRepository;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica;
use SIGESRHI\ExpedienteBundle\Form\PruebapsicologicaType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column;

/**
 * Pruebapsicologica controller.
 *
 */
class PruebapsicologicaController extends Controller
{
    /**
     * Lists all Pruebapsicologica entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->findAll();

        return $this->render('ExpedienteBundle:Pruebapsicologica:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function indexExpedientesEditAction()
    {
        // Creates simple grid based on your entity (ORM)
        $source = new Entity('ExpedienteBundle:Solicitudempleo','grupo_pruebapsicologica_edit');

        // Get a grid instance
        $grid = $this->get('grid');

        $em = $this->getDoctrine()->getManager();
        $query2 = $em->createQuery("SELECT identity(p.idexpediente)
                         FROM ExpedienteBundle:Pruebapsicologica p");

        $resultado = $query2->getResult();
        $idexp=array();
        $idexp[]=0;
        if(!is_null($resultado)){
            foreach ($resultado as $val) {
                foreach ($val as $v){
                    $idexp[]=$v;
                }
            }
        }
        else{
            $idexp[]=0;
        }

        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idexp){
                $query->andWhere('_idexpediente.tipoexpediente = :inv')
                      ->orWhere('_idexpediente.tipoexpediente = :val')
                      ->andWhere($query->expr()->in($tableAlias.'.idexpediente', $idexp))
                      ->setParameter('inv','I')
                      ->setParameter('val','A');
            }
        );

        // Attach the source to the grid
        $grid->setSource($source);  
        
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Inválido');
                             //->setClass('text-error');                    
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                return $row;
            }
        );

        //Columnas a filtrar
        $NombreAspirante = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza', 'filterable'=>false));
        $grid->addColumn($NombreAspirante,1);
        $grid->addColumn($plaza,2);
        
        // Attach a rowAction to the Actions Column
        $rowAction1 = new RowAction('Ver', 'pruebapsicologica_show');
        $rowAction1->setColumn('info_column');
        //Setear parametros al route
        //manipulamos la presentacion del rowaction
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id' => $row->getField('idexpediente.idpruebapsicologica.id'),'exp'=> $row->getField('idexpediente.id')  ));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);  
        $grid->setId('grid_prueba_aspirantes_con');   
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Prueba psicólogica", $this->get("router")->generate("pruebapsicologica_index_edit"));

        return $grid->getGridResponse('ExpedienteBundle:Pruebapsicologica:indexExpedientesCon.html.twig');

    }

    /**
    *Muestra expedientes de empleados para ingresar nueva prueba psicologica
    *
    */
    public function indexExpedientesAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo','grupo_pruebapsicologica');
        $grid = $this->get('grid');

        $em = $this->getDoctrine()->getManager();
        $query2 = $em->createQuery("SELECT identity(p.idexpediente)
                         FROM ExpedienteBundle:Pruebapsicologica p");

        $resultado = $query2->getResult();
        $idexp=array();
        $idexp[]=0;
        if(!is_null($resultado)){
            foreach ($resultado as $val) {
                foreach ($val as $v){
                    $idexp[]=$v;
                }
            }
        }
        else{
            $idexp[]=0;
        }
        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idexp){
                $query->andWhere('_idexpediente.tipoexpediente = :inv')
                       ->orWhere('_idexpediente.tipoexpediente = :val')
                       ->andWhere($query->expr()->notIn($tableAlias.'.idexpediente', $idexp))
                       ->setParameter('inv','I')
                       ->setParameter('val','A');
            });

        $grid->setSource($source);  
        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                // Change the ouput of the column
                if( ($row->getField('idexpediente.tipoexpediente')=='I') || ($row->getField('idexpediente.tipoexpediente')=='A') ) {
                    if($row->getField('idexpediente.tipoexpediente')=='I'){
                        $row->setField('idexpediente.tipoexpediente', 'Inválido');
                            // ->setClass('text-error');                    
                    }
                    if($row->getField('idexpediente.tipoexpediente')=='A'){
                        $row->setField('idexpediente.tipoexpediente', 'Válido');                  
                    }
                }
                return $row;
            }
        );
        $grid->setId('grid_prueba_aspirantes_reg');
        //Columnas a filtrar
        $NombreAspirante = new TextColumn(array('id' => 'nombrecompleto','source' => true,'field'=>'nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza', 'filterable'=>false));
        $grid->addColumn($NombreAspirante,1);
        $grid->addColumn($plaza,2);

        // Attach a rowAction to the Actions Column
        $rowAction1 = new RowAction('Registrar', 'pruebapsicologica_new');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id' => $row->getField('idexpediente.id') ));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Prueba Psicólogica", $this->get("router")->generate("pruebapsicologica_index_edit"));


        return $grid->getGridResponse('ExpedienteBundle:Pruebapsicologica:indexExpedientes.html.twig');

    }

    /**
     * Creates a new Pruebapsicologica entity.
     *
     */
    public function createAction(Request $request)
    {
        //$request = $this->getRequest();
        $idexp=$request->get('exp');

        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteAspirante($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        $entity  = new Pruebapsicologica();
        $entity->setIdexpediente($expediente);
        $form = $this->createForm(new PruebapsicologicaType(), $entity);        
        $form->bind($request);

        if ($form->isValid()) {            
            $band=0;
            switch ($entity->getResultadocoeficiente()) {
                 case 'superior':
                     if($entity-> getCalificacioncoeficiente()<120 || $entity-> getCalificacioncoeficiente()>129){
                        $band=1;
                     }
                     break;
                 case 'alto':
                     if($entity-> getCalificacioncoeficiente()<110 || $entity-> getCalificacioncoeficiente()>119){
                        $band=1;
                     }
                     break;
                 case 'normal':
                     if($entity-> getCalificacioncoeficiente()<90 || $entity-> getCalificacioncoeficiente()>109){
                        $band=1;
                     }                     
                     break;
                 case 'bajo':
                    if($entity-> getCalificacioncoeficiente()<80 || $entity-> getCalificacioncoeficiente()>89){
                        $band=1;
                     }
                     break;
                 default:
                        $band=1;
                     break;
             }         
            if($band==0){
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('new','Prueba Psicologica registrada correctamente');
                return $this->redirect($this->generateUrl('pruebapsicologica_show', array('id'=> $entity->getId(),'exp'=>$idexp)));
            }
            else{
                $this->get('session')->getFlashBag()->add('calificacion','No corresponde al rango');
            }   
        }
        $this->get('session')->getFlashBag()->add('errornew','Errores en la Prueba Psicologica');
        return $this->render('ExpedienteBundle:Pruebapsicologica:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Pruebapsicologica entity.
     *
     */
    public function newAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteAspirante($id);
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);

        $entity = new Pruebapsicologica();
        $entity->setIdexpediente($expediente);
        $form   = $this->createForm(new PruebapsicologicaType(), $entity);

        //$em = $this->getDoctrine()->getManager();
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Prueba Psicologica",$this->get("router")->generate("pruebapsicologica"));
        $breadcrumbs->addItem($expedienteinfo[0]['nombres'],"");


        return $this->render('ExpedienteBundle:Pruebapsicologica:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'form'   => $form->createView(),            
        ));
    }

    /**
     * Finds and displays a Pruebapsicologica entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteAspirante($request->query->get('exp'));
        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);

        $var = $request->get('nogrid');
        $nogrid = (isset($var))?0:1;

        if (!$entity) {
            throw $this->createNotFoundException('No existe entidad Pruebapsicologica.');
        }

        $deleteForm = $this->createDeleteForm($id);
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Prueba Psicologica",$this->get("router")->generate("pruebapsicologica_index_edit"));
        $breadcrumbs->addItem($expedienteinfo[0]['nombres'],"");

        return $this->render('ExpedienteBundle:Pruebapsicologica:show.html.twig', array(
            'entity'      => $entity,
            'expediente' => $expedienteinfo,
            'delete_form' => $deleteForm->createView(),        
            'nogrid' => $nogrid,
            ));
    }

    /**
     * Displays a form to edit an existing Pruebapsicologica entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteAspirante($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));
        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($request->query->get('pr'));
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible cargar el formulario, Intentelo de nuevo.');
        }

        $editForm = $this->createForm(new PruebapsicologicaType($expediente), $entity);
        $deleteForm = $this->createDeleteForm($request->query->get('exp'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Modificar Prueba Psicologica",$this->get("router")->generate("pruebapsicologica_index_edit"));
        $breadcrumbs->addItem($expedienteinfo[0]['nombres'],"");

        return $this->render('ExpedienteBundle:Pruebapsicologica:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'expediente'  =>$expedienteinfo,
            'prueba' => $entity,
        ));
    }

    /**
     * Edits an existing Pruebapsicologica entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $exp = $request->query->get('exp');
        $pr = $request->query->get('pr');
        $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($pr);
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpedienteAspirante($exp);
        //$expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible cargar el formulario, Intentelo de nuevo.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PruebapsicologicaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $band=0;
            switch ($entity->getResultadocoeficiente()) {
                 case 'superior':
                     if($entity-> getCalificacioncoeficiente()<120 || $entity-> getCalificacioncoeficiente()>129){
                        $band=1;
                     }
                     break;
                 case 'alto':
                     if($entity-> getCalificacioncoeficiente()<110 || $entity-> getCalificacioncoeficiente()>119){
                        $band=1;
                     }
                     break;
                 case 'normal':
                     if($entity-> getCalificacioncoeficiente()<90 || $entity-> getCalificacioncoeficiente()>109){
                        $band=1;
                     }                     
                     break;
                 case 'bajo':
                    if($entity-> getCalificacioncoeficiente()<80 || $entity-> getCalificacioncoeficiente()>89){
                        $band=1;
                     }
                     break;
                 default:
                        $band=1;
                     break;
             }  
             if($band==0){
                $em->persist($entity);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('new','Prueba Psicologica modificada correctamente');
                return $this->redirect($this->generateUrl('pruebapsicologica_show', array('id' => $id,'exp'=>$exp)));                
             }  
             else{
                $this->get('session')->getFlashBag()->add('calificacion','No corresponde al rango');                
             } 

        }
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Modificar Prueba Psicologica",$this->get("router")->generate("pruebapsicologica_index_edit"));
        $breadcrumbs->addItem($expedienteinfo[0]['nombres'],"");
        $this->get('session')->getFlashBag()->add('editerror','Error en la información de la Prueba Psicologica');
        return $this->render('ExpedienteBundle:Pruebapsicologica:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'expediente'  =>$expedienteinfo,
            'prueba' => $entity,
        ));
    }

    /**
     * Deletes a Pruebapsicologica entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Pruebapsicologica')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pruebapsicologica entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pruebapsicologica'));
    }

    /**
     * Creates a form to delete a Pruebapsicologica entity by id.
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
