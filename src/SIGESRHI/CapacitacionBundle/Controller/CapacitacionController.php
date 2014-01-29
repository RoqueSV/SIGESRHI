<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\CapacitacionBundle\Entity\Capacitacion;
use SIGESRHI\CapacitacionBundle\Form\CapacitacionType;

/**
 * Capacitacion controller.
 *
 */
class CapacitacionController extends Controller
{
    /**
     * Lists all Capacitacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CapacitacionBundle:Capacitacion')->findAll();

        return $this->render('CapacitacionBundle:Capacitacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Capacitacion entity.
     *
     */
    public function createAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $entity  = new Capacitacion();
        $form = $this->createForm(new CapacitacionType(), $entity);
        $form->bind($request);      

        /**** Validar horas ****/

          $horaini = strtotime( $entity->getHorainiciocapacitacion()->format('H:i') );   
          $horafin = strtotime( $entity->getHorafincapacitacion()->format('H:i') );

        if($horaini > $horafin){
            
            // Incluimos camino de migas
             $breadcrumbs = $this->get("white_october_breadcrumbs");
             $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
             $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
             $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
             $breadcrumbs->addItem("Registrar datos generales",$this->get("router")->generate("plancapacitacion_new"));
             $breadcrumbs->addItem("Registrar capacitaciones","");


            $this->get('session')->getFlashBag()->add('errorcreate', 'Error. La hora inicial es mayor a la final. Verifique los datos');
            return $this->render('CapacitacionBundle:Capacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idplan' => $request->get('idplan'),
            ));
        }
        /**** Fin validar horas ****/

        //Asignar estado
        $entity->setEstadocapacitacion('P'); // Programada

        //Asignar plan
        $idplan = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($request->get('idplan'));
        $entity->setIdplan($idplan);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('avisocapacitacion', 'Capacitación registrada correctamente');
            return $this->redirect($this->generateUrl('capacitacion_new', array(
                                                      'idplan' => $entity->getIdplan()->getId())));
        }

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Registrar datos generales",$this->get("router")->generate("plancapacitacion_new"));
        $breadcrumbs->addItem("Registrar capacitaciones","");

        return $this->render('CapacitacionBundle:Capacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idplan' => $request->get('idplan'),
        ));
    }

    /**
     * Displays a form to create a new Capacitacion entity.
     *
     */
    public function newAction()
    { 
        $request = $this->getRequest();

        $entity = new Capacitacion();
        $form   = $this->createForm(new CapacitacionType(), $entity);

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Registrar datos generales",$this->get("router")->generate("plancapacitacion_new"));
        $breadcrumbs->addItem("Registrar capacitaciones","");


        return $this->render('CapacitacionBundle:Capacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'idplan' => $request->get('idplan'),
        ));
    }

    /**
     * Finds and displays a Capacitacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Capacitacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Capacitacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacion entity.');
        }

        $editForm = $this->createForm(new CapacitacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Capacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Capacitacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Capacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CapacitacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('capacitacion_edit', array('id' => $id)));
        }

        return $this->render('CapacitacionBundle:Capacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Capacitacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CapacitacionBundle:Capacitacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Capacitacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('capacitacion'));
    }

    /**
     * Creates a form to delete a Capacitacion entity by id.
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
