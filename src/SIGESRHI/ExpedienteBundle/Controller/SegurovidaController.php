<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Segurovida;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use SIGESRHI\ExpedienteBundle\Entity\Beneficiario;
use SIGESRHI\ExpedienteBundle\Form\SegurovidaType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;


/**
 * Segurovida controller.
 *
 */
class SegurovidaController extends Controller
{
    /**
     * Registrar nuevos seguros colectivos.
     */
    public function registrarAction()
    {
             
        $source = new Entity('ExpedienteBundle:Expediente','grupo_segurovida');
        
        $grid = $this->get('grid');
        
        /* Empleados activos que no tengan seguro registrado */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->andWhere($query->expr()->isNull('_idsegurovida.id'))
                      ->setParameter('tipo','E');
            }
        );
        
        $grid->setId('grid_segurovida');
        $grid->setSource($source);              

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false));
        $grid->addColumn($CodigoEmpleados,2);
        $grid->addColumn($NombreEmpleados,3);
        

        // Crear
        $rowAction1 = new RowAction('Registrar', 'segurovida_new');
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('codigos', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar seguro colectivo de vida", $this->get("router")->generate("segurovida"));
        
        return $grid->getGridResponse('ExpedienteBundle:Segurovida:index.html.twig');
    }
    

    /**
     * Consultar seguros colectivos.
     */
    public function consultarAction()
    {
             
        $source = new Entity('ExpedienteBundle:Expediente','grupo_segurovida');
        
        $grid = $this->get('grid');
        
        /* Empleados activos que tengan seguro registrado */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->andWhere('_idsegurovida.estadoseguro = :estado')
                      ->andWhere($query->expr()->isNotNull('_idsegurovida.id'))
                      ->setParameter('tipo','E')
                      ->setParameter('estado','V');
            }
        );
        
        $grid->setId('grid_segurovida');
        $grid->setSource($source);              

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false));
        $grid->addColumn($CodigoEmpleados,2);
        $grid->addColumn($NombreEmpleados,3);
        

        // Mostrar
        $rowAction1 = new RowAction('Mostrar', 'segurovida_show_consultar');
        $grid->addRowAction($rowAction1);

        
        $grid->setDefaultOrder('codigos', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar seguro colectivo de vida", $this->get("router")->generate("segurovida_consultar"));
        
        return $grid->getGridResponse('ExpedienteBundle:Segurovida:index.html.twig');
    }


    /**
     * Modificar seguros colectivos.
     */
    public function modificarAction()
    {
             
        $source = new Entity('ExpedienteBundle:Expediente','grupo_segurovida');
        
        $grid = $this->get('grid');
        
        /* Empleados activos que tengan seguro registrado */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoexpediente = :tipo')
                      ->andWhere('_idsegurovida.estadoseguro = :estado')
                      ->andWhere($query->expr()->isNotNull('_idsegurovida.id'))
                      ->setParameter('tipo','E')
                      ->setParameter('estado','V');
            }
        );
        
        $grid->setId('grid_segurovida');
        $grid->setSource($source);              

        //Columnas para filtrar
        $NombreEmpleados = new TextColumn(array('id' => 'empleados','source' => true,'field'=>'idsolicitudempleo.nombrecompleto','title' => 'Nombre',"operatorsVisible"=>false));
        $CodigoEmpleados = new TextColumn(array('id' => 'codigos','source' => true,'field'=>'idempleado.codigoempleado','align'=>'center','title' => 'Código',"operatorsVisible"=>false));
        $grid->addColumn($CodigoEmpleados,2);
        $grid->addColumn($NombreEmpleados,3);
        

        // Mostrar
        $rowAction1 = new RowAction('Modificar', 'segurovida_edit_modificar');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id'=> $row->getField('idsegurovida.id')));
                return $action;
            }
        );

        $grid->addRowAction($rowAction1);


        
        $grid->setDefaultOrder('codigos', 'asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Modificar seguro colectivo de vida", $this->get("router")->generate("segurovida_consultar"));
        
        return $grid->getGridResponse('ExpedienteBundle:Segurovida:index.html.twig');
    }



    /**
     * Crear cuando es nuevo registro.
     *
     */
    public function createAction(Request $request, $id)
    {

        $entity  = new Segurovida();

        // Asignando valores
        $entity->setFechaseguro(new \DateTime("now"));
        //$entity->setEstadoseguro('V');
        
        //Obteniendo idexpediente
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);
        $entity->setIdexpediente($expediente);
        $entity->setEstadoseguro('V');
        
        //Form
        $form = $this->createForm(new SegurovidaType(), $entity);
        $form->bind($request);
        
        //Validando que la suma sea 100%
        $beneficiarios=$entity->getIdbeneficiario();
        $sum=0;  
        foreach ($beneficiarios as $beneficiario) {
           $sum=$sum+$beneficiario->getPorcentaje();
            }
        if($sum!=100){
        $this->get('session')->getFlashBag()->add('error', 'Error. La suma de los porcentajes debe ser igual a 100.');
        /* Obtener datos expediente para mostrar nuevamente en caso de error */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($id);
        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),));
        }// Fin validación
         
        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('aviso', 'Seguro colectivo registrado correctamente');
            
            return $this->redirect($this->generateUrl('segurovida_show', array('id' => $entity->getId())));
        }
        
        $this->get('session')->getFlashBag()->add('error', 'Hubo un error en el procesamiento de los datos. Revise e intente nuevamente.');
        /* Obtener datos expediente para mostrar nuevamente en caso de error */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($id);
        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Formulario cuando es nuevo registro.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();     //Recibir id enviado desde grid
        $entity = new Segurovida();
        
        /*Agregamos datos de beneficiario*/
        $datosBeneficiario = new Beneficiario();
        $datosBeneficiario->name = 'Beneficiarios';
        $entity->getIdBeneficiario()->add($datosBeneficiario);
        
        /* Obtener datos expediente */
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($request->query->get('id'));
      
        //Crear form
        $form   = $this->createForm(new SegurovidaType(), $entity);
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("sonata_user_impersonating"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar seguro colectivo de vida", $this->get("router")->generate("segurovida"));
        $breadcrumbs->addItem("Registro", $this->get("router")->generate("segurovida_new"));

        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Mostrar cuando es nuevo registro.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('No existe el registro seleccionado.');
        }

        // Obtengo id expediente del seguro de vida
        $idexpediente = $entity->getIdexpediente();
        /* Obtener datos expediente */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($idexpediente);
              
        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registra seguro colectivo de vida", $this->get("router")->generate("segurovida"));
        $breadcrumbs->addItem("Ver registro", $this->get("router")->generate("segurovida_show",array("id"=>$id)));

        return $this->render('ExpedienteBundle:Segurovida:show.html.twig', array(
            'entity'       => $entity,
            'expediente'   => $expediente,
            'delete_form'  => $deleteForm->createView(),        ));
    }

    /**
     * Mostrar cuando ya existe registro.
     *
     */
    public function showConsultarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Obtener seguro(s) de vida según idexpediente
        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->findBy(
                 array('idexpediente'=>$id), 
                 array('id' => 'DESC')
               );
        
        if (!$entity) {
            throw $this->createNotFoundException('No existe el registro seleccionado.');
        }
        
        /* Obtener datos expediente */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($id);
        
        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar seguro colectivo de vida", $this->get("router")->generate("segurovida_consultar"));
        $breadcrumbs->addItem("Ver registro", $this->get("router")->generate("segurovida_show_consultar",array("id"=>$id)));

        return $this->render('ExpedienteBundle:Segurovida:show_consultar.html.twig', array(
            'entities'     => $entity,
            'expediente'   => $expediente,
            'delete_form'  => $deleteForm->createView(),        ));

    }

    /**
     * Editar cuando es nuevo registro.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }

        $editForm = $this->createForm(new SegurovidaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
         
        // Obtengo id expediente del seguro de vida
        $idexpediente = $entity->getIdexpediente();

        /* Obtener datos expediente */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($idexpediente);
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar seguro colectivo de vida", $this->get("router")->generate("segurovida"));
        $breadcrumbs->addItem("Editar registro", $this->get("router")->generate("segurovida_edit",array("id"=>$id)));

        return $this->render('ExpedienteBundle:Segurovida:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'expediente'  => $expediente,
        ));
    }


    /**
     * Editar cuando ya existe registro.
     *
     */
    public function editModificarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }

        $editForm = $this->createForm(new SegurovidaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
         
        // Obtengo id expediente del seguro de vida
        $idexpediente = $entity->getIdexpediente();

        /* Obtener datos expediente */
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($idexpediente);
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Modificar seguro colectivo de vida", $this->get("router")->generate("segurovida_modificar"));
        $breadcrumbs->addItem("Modificar registro", $this->get("router")->generate("segurovida_edit_modificar",array("id"=>$id)));

        return $this->render('ExpedienteBundle:Segurovida:edit_modificar.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'expediente'  => $expediente,
        ));
    }

    /**
     * Actualizar cuando es nuevo registro.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }
        

        //Eliminando los embebidos
        // Crea un arreglo del los objetos 'Beneficiario' actualmente en la base de datos
        $originalBeneficiario = array();
        foreach ($entity->getIdbeneficiario() as $beneficiario) {
           $originalBeneficiario[] = $beneficiario;
         } // Fin eliminar embebidos
       
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SegurovidaType(), $entity);
        $editForm->bind($request);
        
        //Validando que envía al menos un registro de beneficiario
        $cantidad = count($entity->getIdbeneficiario());
        if($cantidad<1){
            $this->get('session')->getFlashBag()->add('erroredit', 'Error. Debe registrar al menos un beneficiario!');
            return $this->redirect($this->generateUrl('segurovida_edit', array('id' => $id)));
        }//Fin validacion cantidad

        //Validando que la suma sea 100%
        $beneficiarios=$entity->getIdbeneficiario();
        $sum=0;  
        foreach ($beneficiarios as $beneficiario) {
           $sum=$sum+$beneficiario->getPorcentaje();
            }
        if($sum!=100){
            $this->get('session')->getFlashBag()->add('erroredit', 'Error. El porcentaje asignado debe ser igual al 100%. Repita la operación');
            return $this->redirect($this->generateUrl('segurovida_edit', array('id' => $id)));
        }// Fin validación suma 100

        if ($editForm->isValid()) {

          /* Eliminar Embebidos */
           // Filtra $originalBeneficiario para que contenga los beneficiarios que ya no están presentes
            foreach ($entity->getIdbeneficiario() as $beneficiario) {
                foreach ($originalBeneficiario as $key => $toDel) {
                    if ($toDel->getId() === $beneficiario->getId()) {
                        unset($originalBeneficiario[$key]);
                    }
                }
            }

          // Elimina la relación entre beneficiario y segurodevida
            foreach ($originalBeneficiario as $beneficiario) {
                  $beneficiario->setIdsegurovida(null);
                 $em->remove($beneficiario);
         
             }

            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('edit', 'Seguro colectivo modificado correctamente');
            return $this->redirect($this->generateUrl('segurovida_show', array('id' => $id)));
        
        } //fin isValid

        /* Obtener datos expediente */
        $idexpediente = $entity->getIdexpediente();
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($idexpediente);
        
        return $this->render('ExpedienteBundle:Segurovida:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'expediente'  => $expediente,
        ));
    }

    /**
     * Actualizar cuando ya existe registro
     *
     */

    public function updateModificarAction(Request $request, $id, $idsv)
    {

        $entity  = new Segurovida();

        // Asignando valores
        $entity->setFechaseguro(new \DateTime("now"));
        //$entity->setEstadoseguro('V');
        
        //Obteniendo idexpediente
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);
        $entity->setIdexpediente($expediente);       
        $entity->setEstadoseguro('V');
        
        //Form
        $form = $this->createForm(new SegurovidaType(), $entity);
        $form->bind($request);
        
        //Validando que envía al menos un registro de beneficiario
        $cantidad = count($entity->getIdbeneficiario());
        if($cantidad<1){
            $this->get('session')->getFlashBag()->add('erroredit', 'Error. Debe registrar al menos un beneficiario!');
            return $this->redirect($this->generateUrl('segurovida_edit_modificar', array('id' => $idsv)));
        }//Fin validacion cantidad

        //Validando que la suma sea 100%
        $beneficiarios=$entity->getIdbeneficiario();
        $sum=0;  
        foreach ($beneficiarios as $beneficiario) {
           $sum=$sum+$beneficiario->getPorcentaje();
            }
        if($sum!=100){
        $this->get('session')->getFlashBag()->add('erroredit', 'Error. La suma de los porcentajes debe ser igual a 100.');
        return $this->redirect($this->generateUrl('segurovida_edit_modificar', array('id' => $idsv)));
        }// Fin validación
         
        if ($form->isValid()) {
            // Cambiar estado a demas registros
            if(count($entity->getIdexpediente()->getIdsegurovida())>=1){      
             foreach ($entity->getIdexpediente()->getIdsegurovida() as $seguros) {
               $seguros->setEstadoseguro('N');
               $em->persist($seguros);
         } 
        }


            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('aviso', 'Seguro colectivo modificado correctamente');
            return $this->redirect($this->generateUrl('segurovida_consultar', array('id' => $id)));
        }
        
        $this->get('session')->getFlashBag()->add('error', 'Hubo un error en el procesamiento de los datos. Revise e intente nuevamente.');
        return $this->redirect($this->generateUrl('segurovida_edit_modificar', array('id' => $idsv)));

    }


    /**
     * Deletes a Segurovida entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Segurovida entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente');
        return $this->redirect($this->generateUrl('segurovida'));
    }

    /**
     * Creates a form to delete a Segurovida entity by id.
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
