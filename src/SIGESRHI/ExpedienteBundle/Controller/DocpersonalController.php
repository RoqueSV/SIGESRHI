<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Docpersonal;
use SIGESRHI\ExpedienteBundle\Form\DocpersonalType;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column;

/**
 * Docpersonal controller.
 *
 * @Route("/docpersonal")
 */
class DocpersonalController extends Controller
{
    /**
     * Lists all Docpersonal entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo','vista_basica_expediente');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->Join($tableAlias.'.idexpediente','e')
                       ->andWhere('e.tipoexpediente = :inv')
                       ->orWhere('e.tipoexpediente = :val')
                       ->setParameter('inv','I')
                       ->setParameter('val','A');
            }
        );

        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");

        $rowAction1 = new RowAction('Ingresar', 'docpersonal_new');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action;
            }
        );

        $grid->addRowAction($rowAction1);     
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "hello_page");
        $breadcrumbs->addItem("Registrar documentos de expediente Personal", "");

        return $grid->getGridResponse('ExpedienteBundle:Docpersonal:index.html.twig');

    /*    $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Docpersonal')->findAll();

        return array(
            'entities' => $entities,
        ); */
    }

    /**
     * Creates a new Docpersonal entity.
     *
     */
    public function createAction(Request $request)
    {
        $idexp=$request->get('exp');
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        $Documentos = $em->getRepository('ExpedienteBundle:Docpersonal')->find($request->query->get('exp'));

        $entity  = new Docpersonal();
        $entity->setIdexpediente($expediente);
        $entity->setentregado(1);
        $form = $this->createForm(new DocpersonalType(), $entity);
        $form->bind($request);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "hello_page");
        $breadcrumbs->addItem("Registrar documentos de expediente Personal","");

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new','Documento Registrada correctamente');
            //return $this->redirect($this->generateUrl('docpersonal_show', array('id' => $entity->getId())));
            return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
        ));
        }

        $this->get('session')->getFlashBag()->add('errornew','Errores en el Documento registrado');
        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Docpersonal entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $em = $this->getDoctrine()->getManager();
        $expedienteinfo = $em->getRepository('ExpedienteBundle:Expediente')->obtenerExpediente($request->query->get('exp'));
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($request->query->get('exp'));

        $Documentos = $em->getRepository('ExpedienteBundle:Docpersonal')->find($request->query->get('exp'));

        $entity = new Docpersonal();
        $entity->setIdexpediente($expediente);
        $entity->setentregado(1);
        $form   = $this->createForm(new DocpersonalType(), $entity);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", "hello_page");
        $breadcrumbs->addItem("Gestion de Aspirantes", "hello_page");
        $breadcrumbs->addItem("Registrar documentos de expediente Personal","");

        return $this->render('ExpedienteBundle:Docpersonal:new.html.twig', array(
            'entity' => $entity,
            'expediente' => $expedienteinfo,
            'documentos' => $Documentos,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Docpersonal entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Docpersonal entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $editForm = $this->createForm(new DocpersonalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Docpersonal entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docpersonal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DocpersonalType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docpersonal_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Docpersonal entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Docpersonal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Docpersonal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docpersonal'));
    }

    /**
     * Creates a form to delete a Docpersonal entity by id.
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
