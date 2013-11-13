<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Docexpediente;
use SIGESRHI\ExpedienteBundle\Form\DocexpedienteType;

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

            return $this->redirect($this->generateUrl('docdigital_new', array('id' => $entity->getIdexpediente()->getId())));
            /* return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'id' => $entity->getIdexpediente(),
            'form'   => $form->createView(),
            'documentos' => $Documentos,
        ));*/
        }

        return $this->render('ExpedienteBundle:Docexpediente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Docexpediente entity.
     *
     */
    public function newAction()
    {
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
                throw $this->createNotFoundException('Unable to find Docexpediente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docdigital'));
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
}
