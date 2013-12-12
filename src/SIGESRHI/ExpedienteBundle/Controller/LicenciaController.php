<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIGESRHI\ExpedienteBundle\Entity\Licencia;
use SIGESRHI\ExpedienteBundle\Form\LicenciaType;

use SIGESRHI\ExpedienteBundle\Entity\Expediente;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
/**
 * Licencia controller.
 *
 * @Route("/licencia")
 */
class LicenciaController extends Controller
{
    /**
     * Lists all Licencia entities.
     *
     * @Route("/", name="licencia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $source = new Entity('ExpedienteBundle:Solicitudempleo','vista_basica_expediente');
        $grid = $this->get('grid');
        $grid->setSource($source);  
        $grid->setNoDataMessage("No se encontraron resultados");

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->Join($tableAlias.'.idexpediente','e')
                        ->Join('e.idempleado','em')
                        ->Join('em.idcontratacion','c')
                        ->andWhere('e.tipoexpediente = :emp')
                        ->andWhere('c.fechafincontrato IS NULL')
                        ->setParameter('emp','E');
            }
        );
        $plaza = new TextColumn(array('id' => 'plaza','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Plaza',"operatorsVisible"=>false));
        $grid->addColumn($plaza,3);

        $rowAction1 = new RowAction('Ver', 'licencia_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $rowAction2 = new RowAction('Registrar', 'licencia_new');
        $rowAction2->setColumn('info_column');
        $rowAction2->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id','exp'=> $row->getField('idexpediente.id') ));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction2); 

        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente",$this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Licencias",$this->get("router")->generate("hello_page"));
        
        return $grid->getGridResponse('ExpedienteBundle:Licencia:index.html.twig');
    }

    /**
     * Creates a new Licencia entity.
     *
     * @Route("/", name="licencia_create")
     * @Method("POST")
     * @Template("ExpedienteBundle:Licencia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Licencia();
        $form = $this->createForm(new LicenciaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('licencia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Licencia entity.
     *
     * @Route("/new", name="licencia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Licencia();
        $form   = $this->createForm(new LicenciaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Licencia entity.
     *
     * @Route("/{id}", name="licencia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Licencia entity.
     *
     * @Route("/{id}/edit", name="licencia_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $editForm = $this->createForm(new LicenciaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Licencia entity.
     *
     * @Route("/{id}", name="licencia_update")
     * @Method("PUT")
     * @Template("ExpedienteBundle:Licencia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LicenciaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('licencia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Licencia entity.
     *
     * @Route("/{id}", name="licencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Licencia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('licencia'));
    }

    /**
     * Creates a form to delete a Licencia entity by id.
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
