<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\RefrendaAct;
use SIGESRHI\ExpedienteBundle\Form\RefrendaActType;

/**
 * RefrendaAct controller.
 *
 */
class RefrendaActController extends Controller
{
    /**
     * Lists all RefrendaAct entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:RefrendaAct')->findAll();

        return $this->render('ExpedienteBundle:RefrendaAct:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new RefrendaAct entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity  = new RefrendaAct();

        $entity->setNombreplaza('Pruebaplaza');

        $form = $this->createForm(new RefrendaActType(), $entity);
        $form->bind($request);

       // $plaza = $em->getRepository('AdminBundle:Plaza')->find($entity->getIdplaza());
       // $entity->setIdplaza($plaza);
        
        
       // $unidad = $em->getRepository('AdminBundle:Unidadorganizativa')->find($entity->getIdunidad());
       // $entity->setIdunidad($unidad);

        echo $entity->getSubpartida()."-".$entity->getPartida()."-".$entity->getSueldoactual()."-".$entity->getUnidadpresupuestaria()."-".$entity->getLineapresupuestaria()."-".$entity->getCodigolp()."-".$entity->getTipo()."-".$entity->getIdplaza()."-".$entity->getIdunidad();
        if ($form->isValid()) {
            

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Puesto registrado correctamente.');

            return $this->redirect($this->generateUrl('refrendaact_show', array('id' => $entity->getId())));
        }

        $this->get('session')->getFlashBag()->add('aviso', 'Ha habido un error. Repita la operación');
        $tipo = $request->get('tipo'); 
        $tipocontratacion = $request->get('tipocontratacion'); 
        $idexp = $request->get('idexp');

        return $this->render('ExpedienteBundle:RefrendaAct:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp
        ));
    }

    /**
     * Displays a form to create a new RefrendaAct entity.
     *
     */
    public function newAction()
    {

        $request=$this->getRequest();

        $tipo = $request->get('tipo'); // tipo de contratacion = 1- nombramiento, 2-contrato
        $tipocontratacion = $request->get('tipocontratacion'); // quien se contrata =  1- aspirante, 2- empleado
        $idexp = $request->get('idexp');

        $entity = new RefrendaAct();
        $form   = $this->createForm(new RefrendaActType(), $entity);

        //Camino de migas
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        if ($tipocontratacion == 1) {//aspirante
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        }
        else { //empleado 
        $breadcrumbs->addItem("Empleado activo", $this->get("router")->generate("pantalla_empleadoactivo"));
        $breadcrumbs->addItem("Registrar contratación", $this->get("router")->generate("contratacion_empleado"));
        }
        if ($tipo == 1){ //Ley de salarios
        $breadcrumbs->addItem("Registrar nombramiento",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("contratacion_new"));
        }
        else if ($tipo == 2){ //Contrato
        $breadcrumbs->addItem("Registrar contrato",  $this->get("router")->generate("contratacion_tipo",array('tipo'=>$tipo,'tipogrid'=>$tipocontratacion,'idexp'=>$idexp)));
        $breadcrumbs->addItem("Nuevo puesto",  $this->get("router")->generate("contratacion_new"));
        }

        return $this->render('ExpedienteBundle:RefrendaAct:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipo'   => $tipo,
            'tipocontratacion' => $tipocontratacion,
            'idexp' => $idexp
        ));
    }

    /**
     * Finds and displays a RefrendaAct entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:RefrendaAct:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing RefrendaAct entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        $editForm = $this->createForm(new RefrendaActType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:RefrendaAct:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing RefrendaAct entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RefrendaActType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('refrendaact_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:RefrendaAct:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RefrendaAct entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:RefrendaAct')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RefrendaAct entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('refrendaact'));
    }

    /**
     * Creates a form to delete a RefrendaAct entity by id.
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
