<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\PortalEmpleadoBundle\Entity\Solicitudcapacitacion;

use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;

use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Capacitacion controller.
 *
 */
class SolicitudCapacitacionController extends Controller
{
   
   //Consultar solicitudes de empleados
	public function consultarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        
        //validamos que el usuario este logueado
        if($user== "anon.")
        {
            throw $this->createNotFoundException('Inicie sesión para acceder a esta página');
        }
        
        $idjefe = $user->getEmpleado()->getId();

        $source = new Entity('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion','solicitud_empleado');
        $grid = $this->get('grid');
        $grid->setSource($source); 
        
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idjefe){
                $query->andWhere('_idjefe.id = :emp')
                      ->setParameter('emp', $idjefe);
            }
        ); 

        $source->manipulateRow(
            function ($row)
            {
            // Change the ouput of the column quantity if anarticle is sold out
            if ($row->getField('aprobacionsolicitud') == 'R') {
                $row->setField('aprobacionsolicitud', "No aprobada");
            }
            if ($row->getField('aprobacionsolicitud') == 'A') {
                $row->setField('aprobacionsolicitud', "Aprobada");
            }
            if ($row->getField('aprobacionsolicitud') == 'P') {
                $row->setField('aprobacionsolicitud', "Pendiente");
            }

            return $row;
            }
        );       

        $rowAction1 = new RowAction('Ver detalle', 'detalle_solicitud');
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_solicitudcapacitacion');
        $grid->setDefaultOrder('fechasolicitud','desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones / Solicitudes", $this->get("router")->generate("solicitud_capacitacion"));       
        
        return $grid->getGridResponse('CapacitacionBundle:SolicitudCapacitacion:solicitud_capacitacion.html.twig');

    }

    public function detalleSolicitudAction()
    { 
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($request->get('id'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones / Solicitudes", $this->get("router")->generate("solicitud_capacitacion"));
        $breadcrumbs->addItem("Aprobación de solicitudes", $this->get("router")->generate("detalle_solicitud"));


        return $this->render('CapacitacionBundle:SolicitudCapacitacion:detalle_solicitud.html.twig', array(
            'entity' => $entity,
        ));
    }

    public function solicitudUpdateAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('idsol');

        $entity = $em->getRepository('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $entity->setComentariosolicitud($request->get('comentario'));
        $entity->setAprobacionsolicitud($request->get('estado'));

            $em->persist($entity);
            $em->flush();

        if($entity->getAprobacionsolicitud() == 'A'){
           $this->get('session')->getFlashBag()->add('aviso','Solicitud aprobada correctamente');
        }
        else{
           $this->get('session')->getFlashBag()->add('aviso','Solicitud rechazada, registro actualizado');
        }
        return $this->redirect($this->generateUrl('solicitud_capacitacion'));

    }

}