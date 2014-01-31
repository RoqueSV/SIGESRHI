<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Memorandum;
use SIGESRHI\AdminBundle\Entity\RefrendaAct;
use SIGESRHI\ExpedienteBundle\Form\MemorandumType;

/**
 * Memorandum controller.
 *
 */
class MemorandumController extends Controller
{
    /**
     * Lists all Memorandum entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Memorandum')->findAll();
 

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Documentos", $this->get("router")->generate("pantalla_documentos"));
        $breadcrumbs->addItem("Elegir tipo memorándum", $this->get("router")->generate("memorandum"));

        return $this->render('ExpedienteBundle:Memorandum:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Memorandum entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity  = new Memorandum();
        $form = $this->createForm(new MemorandumType(), $entity);

        $form->bind($request);

        //$empleado = $form->get('empleado')->getData();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('memorandum_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Memorandum:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Memorandum entity.
     *
     */
    public function newAction()
    {

        $request = $this->getRequest();
        $tipomemo = $request->get('tipomemo');

        $entity = new Memorandum();
        
        $form   = $this->createForm(new MemorandumType(), $entity);
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Generar reportes y documentos", $this->get("router")->generate("pantalla_modulo",array('id'=>5)));
        $breadcrumbs->addItem("Documentos", $this->get("router")->generate("pantalla_documentos"));
        $breadcrumbs->addItem("Elegir tipo memorándum", $this->get("router")->generate("memorandum"));
        $breadcrumbs->addItem("Nuevo memorándum", $this->get("router")->generate("memorandum_new",array('tipomemo'=>$tipomemo)));

        return $this->render('ExpedienteBundle:Memorandum:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tipomemo' => $tipomemo
        ));
    }

    /**
     * Finds and displays a Memorandum entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Memorandum:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Memorandum entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $editForm = $this->createForm(new MemorandumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Memorandum:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Memorandum entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Memorandum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MemorandumType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('memorandum_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Memorandum:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Memorandum entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Memorandum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Memorandum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('memorandum'));
    }

    /**
     * Creates a form to delete a Memorandum entity by id.
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


    public function consultarCargosJSONAction(){

    $request = $this->getRequest();
    $idEmpleado = $request->get('idempleado');
    $em=$this->getDoctrine()->getManager(); 
    $Empleado = $em->getRepository('ExpedienteBundle:Empleado')->find($idEmpleado); //agregado
    $puestos = $Empleado->getIdrefrenda();  
    $numfilas = count($puestos);

    $puesto = new RefrendaAct();
    $i = 0;

       foreach ($puestos as $puesto){
        $rows[$i]['id'] = $puesto->getId();
        $rows[$i]['cell'] = array($puesto->getId(), 
            $puesto->getNombreplaza(),
            $puesto->getIdempleado());
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

}
