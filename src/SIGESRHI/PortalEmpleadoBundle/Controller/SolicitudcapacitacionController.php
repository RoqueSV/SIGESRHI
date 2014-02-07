<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;

use SIGESRHI\PortalEmpleadoBundle\Entity\Solicitudcapacitacion;
use SIGESRHI\PortalEmpleadoBundle\Form\SolicitudcapacitacionType;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Solicitudcapacitacion controller.
 *
 */
class SolicitudcapacitacionController extends Controller
{
    /**
     * Lists all Solicitudcapacitacion entities.
     *
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();

        $source = new Entity('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion','solEmpleado');
        $grid = $this->get('grid');
        $grid->setSource($source); 
        
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idempleado){
                $query->andWhere($tableAlias.'.idempleado = :emp')
                      ->setParameter('emp', $idempleado);
            }
        );        
        $rowAction1 = new RowAction('Ver detalle', 'solicitudcapacitacion_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_solicitudesEmpleado');
        $grid->setDefaultOrder('fechasolicitud','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:index.html.twig');
    }
    /**
    *Ver capacitaciones disponibles para el empleado
    */
    public function indexCapasAction(){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();

        $source = new Entity('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion','solEmpleado');
        $grid = $this->get('grid');
        $grid->setSource($source); 
        
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idempleado){
                $query->andWhere($tableAlias.'.idempleado = :emp')
                      ->setParameter('emp', $idempleado);
            }
        );        
        $rowAction1 = new RowAction('Ver detalle', 'solicitudcapacitacion_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_solicitudesEmpleado');
        $grid->setDefaultOrder('fechasolicitud','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        return $grid->getGridResponse('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:indexCapas.html.twig');
    }

    /**
     * Creates a new Solicitudcapacitacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $empleadoform = $em->getRepository('ExpedienteBundle:Empleado')->find($request->get('idempleado'));
        $capacitacionform = $em->getRepository('CapacitacionBundle:Capacitacion')->find($request->get('idcapa'));
        
        $entity  = new Solicitudcapacitacion();
        $entity -> setAprobacionsolicitud('R');
        $entity -> setFechasolicitud(new \Datetime(date('d-m-Y')));        
        $entity -> setIdcapacitacion($capacitacionform);
        $entity -> setIdempleado($empleadoform);        
        $form = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('new','Solicitud registrada correctamente'); 
            return $this->redirect($this->generateUrl('solicitudcapacitacion'));
        }
        //retornamos al form
        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();

        $capacitacion = $em->getRepository('CapacitacionBundle:Capacitacion')->find($idcapa);
        if($capacitacion!=null AND $empleado!=null){
            $this->get('session')->getFlashBag()->add('errornew','Errores en el Registro de Solicitud');
            return $this->render('  SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'capacitacion' => $capacitacion,
                'empleado' => $empleado,
            ));
        }
        throw $this->createNotFoundException('No se encontro capacitacion, ni empleado');
    }

    /**
     * Displays a form to create a new Solicitudcapacitacion entity.
     *
     */
    public function newAction($idcapa)
    {
        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();

        $em = $this->getDoctrine()->getManager();
        $capacitacion = $em->getRepository('CapacitacionBundle:Capacitacion')->find($idcapa);
        if($capacitacion!=null AND $empleado!=null){
            $entity = new Solicitudcapacitacion();
            $form   = $this->createForm(new SolicitudcapacitacionType(), $entity);            

            return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'capacitacion' => $capacitacion,
                'empleado' => $empleado,
            ));
        }
        else
            throw $this->createNotFoundException('No se encontro capacitacion, ni empleado');
    }

    /**
     * Finds and displays a Solicitudcapacitacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Solicitudcapacitacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $editForm = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Solicitudcapacitacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SolicitudcapacitacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitudcapacitacion_edit', array('id' => $id)));
        }

        return $this->render('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Solicitudcapacitacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitudcapacitacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitudcapacitacion'));
    }

    /**
     * Creates a form to delete a Solicitudcapacitacion entity by id.
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
