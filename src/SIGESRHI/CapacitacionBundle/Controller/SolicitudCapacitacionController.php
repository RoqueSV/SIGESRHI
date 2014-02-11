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
        $jefe = $em->getRepository('ExpedienteBundle:Empleado')->find($idjefe);

        //Número de puestos que tiene el jefe logueado
        $numpuestos = count($jefe->getIdrefrenda());

        //$jefe = $em->getRepository('ExpedienteBundle:Empleado')->find($idjefe);

        $source = new Entity('SIGESRHIPortalEmpleadoBundle:Solicitudcapacitacion','solicitud_empleado');
        $grid = $this->get('grid');
        $grid->setSource($source); 
        
        /*$tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idempleado){
                $query->andWhere($tableAlias.'.idempleado = :emp')
                      ->setParameter('emp', $idempleado);
            }
        );*/ 

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
        $rowAction1 = new RowAction('Ver detalle', 'solicitudcapacitacion_show');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_solicitudcapacitacion');
        $grid->setDefaultOrder('fechasolicitud','desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        
        return $grid->getGridResponse('CapacitacionBundle:SolicitudCapacitacion:solicitud_capacitacion.html.twig');

        /*return $this->render('CapacitacionBundle:SolicitudCapacitacion:solicitud_capacitacion.html.twig', array(
                'puesto' => $idjefe,
                'jefe'   => $numpuestos,
            ));*/
    }

}