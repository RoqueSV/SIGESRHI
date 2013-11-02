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
     * Lists all Segurovida entities.
     *
     */
    public function indexAction()
    {
        
        $source = new Entity('ExpedienteBundle:Expediente','grupo_segurovida');

        $grid = $this->get('grid');

        $source->manipulateRow(
            function ($row)
            {
                        
            // Mostrar solo los expedientes sin seguro de vida
            if ($row->getField('idsegurovida.id')>0 ) {
            return null;
            }
            
            // Mostrar solo empleados activos
            if ($row->getField('tipoexpediente')!='E' ) {
            return null;
            }
            //concat columns
          // $row->setField('idsolicitudempleo.nombres', $row->getField('idsolicitudempleo.nombres')." ".$row->getField('idsolicitudempleo.primerapellido')." ".$row->getField('idsolicitudempleo.segundoapellido'));
            return $row;
            }
        );

        
        $grid->setSource($source);
                               

        
        // Crear
        $rowAction1 = new RowAction('Crear', 'segurovida_new',true,'_self');
        $rowAction1->setRouteParameters(array('id'));
        $rowAction1->SetConfirmMessage('Are you sure?');
        $rowAction1->setColumn('info_column');
        $grid->addRowAction($rowAction1);
        
         $MyMappedColumn = new TextColumn(array('id' => 'Nombre', 'field' => $this->getField('idsolicitudempleo.nombres')." ".$this->getField('idsolicitudempleo.primerapellido'),'source' => true, 'title' => 'Nombre Completo', 'joinType'=>'inner'));
         $grid->addColumn($MyMappedColumn); 

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida"));

        return $grid->getGridResponse('ExpedienteBundle:Segurovida:index.html.twig');
    }

    /**
     * Creates a new Segurovida entity.
     *
     */
    public function createAction(Request $request, $id)
    {

        $entity  = new Segurovida();

        // Asignando valores
        $entity->setFechaseguro(new \DateTime("now"));
        $entity->setEstadoseguro('V');
        
        //Obteniendo idexpediente
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($id);
        $entity->setIdexpediente($expediente);
        
        //Asignando estado, dependiendo si el expediente ya tiene un segurovida

        /*if(count($entity->getIdexpediente()->getIdsegurovida())>=1){
            $entity->setEstadoseguro('N');
        }
        else {$entity->setEstadoseguro('V');}*/

        
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
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($id);
        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),));
        }// Fin validación
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('aviso', 'Seguro colectivo registrado correctamente');
            
            return $this->redirect($this->generateUrl('segurovida_show', array('id' => $entity->getId())));
        }
        
        $this->get('session')->getFlashBag()->add('error', 'Hubo un error en el procesamiento de los datos. Revise e intente nuevamente.');
        /* Obtener datos expediente para mostrar nuevamente en caso de error */
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Segurovida')->obtenerDatosGenerales($id);
        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Displays a form to create a new Segurovida entity.
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
        $breadcrumbs->addItem("Seguro de vida", $this->get("router")->generate("segurovida"));
        $breadcrumbs->addItem("Registro", $this->get("router")->generate("segurovida_new"));

        return $this->render('ExpedienteBundle:Segurovida:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expediente,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Segurovida entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Segurovida')->find($id);

        // Obtengo id expediente de un seguro de vida especifico
        $query = $em->createQuery('
          SELECT e.id idexp FROM ExpedienteBundle:Segurovida s
          JOIN s.idexpediente e
          WHERE s.id = :idseguro'
        )->setParameter('idseguro', $id);
        $idexpediente = $query->getResult();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Segurovida entity.');
        }
        

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Segurovida:show.html.twig', array(
            'entity'       => $entity,
            'idexpediente' => $idexpediente,
            'delete_form'  => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Segurovida entity.
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
     * Edits an existing Segurovida entity.
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
            return $this->redirect($this->generateUrl('segurovida_edit', array('id' => $id)));
        
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
        $this->get('session')->getFlashBag()->add('delete', 'Seguro de vida eliminado');
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
