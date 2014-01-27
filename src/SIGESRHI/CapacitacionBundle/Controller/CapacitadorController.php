<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\CapacitacionBundle\Entity\Capacitador;
use SIGESRHI\CapacitacionBundle\Form\CapacitadorType;

use SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora;
use SIGESRHI\CapacitacionBundle\Form\InstitucioncapacitadoraType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
/**
 * Capacitador controller.
 *
 */
class CapacitadorController extends Controller
{
    /**
     * Lists all Capacitador entities.
     *
     */
    public function consultarAction()
    {
        $source = new Entity('CapacitacionBundle:Capacitador','grupo_capacitador');
        
        $grid = $this->get('grid');
  
        
        $grid->setId('grid_capacitador');
        $grid->setSource($source);             
        
        // Crear
        $rowAction1 = new RowAction('Consultar', 'capacitador_show');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','pag'=> 1));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);

        //$grid->setDefaultOrder('fechaexpediente', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
        $breadcrumbs->addItem("Consultar facilitador", $this->get("router")->generate("hello_page"));

        return $grid->getGridResponse('CapacitacionBundle:Capacitador:index.html.twig');
    }

    public function modificarAction()
    {
        $source = new Entity('CapacitacionBundle:Capacitador','grupo_capacitador');
        
        $grid = $this->get('grid');
  
        
        $grid->setId('grid_capacitador');
        $grid->setSource($source);             
        
        // Modificar
        $rowAction1 = new RowAction('Modificar', 'capacitador_edit');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','pag'=> 3));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);

        //$grid->setDefaultOrder('fechaexpediente', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
        $breadcrumbs->addItem("Modificar facilitador", $this->get("router")->generate("hello_page"));

        return $grid->getGridResponse('CapacitacionBundle:Capacitador:index.html.twig');
    }

    public function eliminarAction()
    {
        $source = new Entity('CapacitacionBundle:Capacitador','grupo_capacitador');
        
        $grid = $this->get('grid');
  
        
        $grid->setId('grid_capacitador');
        $grid->setSource($source);             
        
        // Eliminar
        $rowAction1 = new RowAction('Eliminar', 'capacitador_confelim');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                 $action->setRouteParameters(array('id','pag'=> 4));
                return $action;
            }
        );
        $grid->addRowAction($rowAction1);

        //$grid->setDefaultOrder('fechaexpediente', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
        $breadcrumbs->addItem("ELiminar facilitador", $this->get("router")->generate("hello_page"));

        return $grid->getGridResponse('CapacitacionBundle:Capacitador:index.html.twig');
    }

    /**
     * Creates a new Capacitador entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Capacitador();
        $form = $this->createForm(new CapacitadorType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Capacitador registrado correctamente.');
            return $this->redirect($this->generateUrl('capacitador_show', array('id' => $entity->getId(),'pag'=>2)));
        }

        return $this->render('CapacitacionBundle:Capacitador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Capacitador entity.
     *
     */
    public function newAction()
    {
        $entity = new Capacitador();
        $form   = $this->createForm(new CapacitadorType(), $entity);

        /*** -Institucion ***/
        $institucion = new Institucioncapacitadora();
        $forminst   = $this->createForm(new InstitucioncapacitadoraType(), $institucion);
        /** ---- **/
      
         // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
        $breadcrumbs->addItem("Registrar facilitador", $this->get("router")->generate("hello_page"));

        return $this->render('CapacitacionBundle:Capacitador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'forminst'=>$forminst->createView(),
        ));
    }

    /**
     * Finds and displays a Capacitador entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $pagina = $request->get('pag');

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));

        if($pagina == 1){
           $breadcrumbs->addItem("Consultar facilitador", $this->get("router")->generate("capacitador")); 
        }
        else{
           $breadcrumbs->addItem("Registrar facilitador", $this->get("router")->generate("capacitador_new")); 
        }
        $breadcrumbs->addItem("Datos de registro", $this->get("router")->generate("capacitador_new"));

        return $this->render('CapacitacionBundle:Capacitador:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),   
            'pag'         => $pagina,     ));
    }

    /**
     * Displays a form to edit an existing Capacitador entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
   
        $entity = $em->getRepository('CapacitacionBundle:Capacitador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitador entity.');
        }

        $editForm = $this->createForm(new CapacitadorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

         // Incluimos camino de migas
        $pagina = $request->get('pag');
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));

        if($pagina == 1){
          $breadcrumbs->addItem("Consultar facilitador", $this->get("router")->generate("capacitador"));  
          $breadcrumbs->addItem("Datos de registro", $this->get("router")->generate("capacitador_show",array('id'=>$id,'pag'=>$pagina)));
        }
        else if($pagina == 2){
          $breadcrumbs->addItem("Registrar facilitador", $this->get("router")->generate("capacitador_new"));
          $breadcrumbs->addItem("Datos de registro", $this->get("router")->generate("capacitador_show",array('id'=>$id,'pag'=>$pagina)));
        }   
        else{
          $breadcrumbs->addItem("Modificar facilitador", $this->get("router")->generate("capacitador_modificar")); 
        }
        
        $breadcrumbs->addItem("Edición de datos", "");

        return $this->render('CapacitacionBundle:Capacitador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pag'         => $pagina,
        ));
    }

    /**
     * Edits an existing Capacitador entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CapacitadorType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('edit', 'Registro modificado correctamente.');

            if($request->get('pag') == 3){
               return $this->redirect($this->generateUrl('capacitador_edit', array('id' => $id,'pag'=>$request->get('pag')))); 
            }
            else{
               return $this->redirect($this->generateUrl('capacitador_show', array('id' => $id,'pag'=>$request->get('pag'))));  
            }

            
        }

        return $this->render('CapacitacionBundle:Capacitador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pag'         => $request->get('pag'),
        ));
    }

    public function confEliminarAction($id){

     $request = $this->getRequest();
     $em = $this->getDoctrine()->getManager();

     $entity = $em->getRepository('CapacitacionBundle:Capacitador')->find($id);
     
     $deleteForm = $this->createDeleteForm($id);

     if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitador entity.');
        }

    $numcapacitaciones = count($entity->getIdcapacitacion());

     //Incluimos camino de migas
     $breadcrumbs = $this->get("white_october_breadcrumbs");
     $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
     $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
     $breadcrumbs->addItem("Facilitadores", $this->get("router")->generate("pantalla_facilitadores"));
     $breadcrumbs->addItem("Eliminar facilitador", $this->get("router")->generate("capacitador_eliminar"));
     $breadcrumbs->addItem("Eliminar registro", $this->get("router")->generate("pantalla_facilitadores"));

    return $this->render('CapacitacionBundle:Capacitador:delete.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'pag'         => $request->get('pag'),
            'numcapacitaciones' => $numcapacitaciones,
        ));

    }

    /**
     * Deletes a Capacitador entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CapacitacionBundle:Capacitador')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Capacitador entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente');
        
        $pagina = $request->get('pag');
        if($pagina == 1){ // consultar
           return $this->redirect($this->generateUrl('capacitador')); 
        }
        else if($pagina == 4){ //eliminar
           return $this->redirect($this->generateUrl('capacitador_eliminar'));  
        }
        else{
           return $this->redirect($this->generateUrl('pantalla_facilitadores'));  
        }
    }

    /**
     * Creates a form to delete a Capacitador entity by id.
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
