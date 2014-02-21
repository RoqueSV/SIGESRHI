<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\ExpedienteBundle\Entity\Contratacion;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Empleado controller.
 *
 */
class EmpleadoportalController extends Controller
{
    /**
     * Vista de informacion del Empleado
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        if($user == 'anon.'){
			return $this->redirect($this->generateUrl('hello_page'));        	
        }
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();

        $entity = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
        }
        //obtenemos las plazas del empleado
        $query = $em -> createQuery("SELECT r.nombreplaza, r.sueldoactual FROM ExpedienteBundle:Empleado e JOIN e.idrefrenda r WHERE e.id=:idempleado")
                    ->setParameter('idempleado',$idempleado);
        $plazas = $query->getResult();
        
        //obtenemos los datos de estudio
        $query2 = $em -> createQuery("SELECT de.centroestudio, t.niveltitulo, t.nombretitulo  FROM ExpedienteBundle:Empleado e JOIN e.idexpediente ex JOIN ex.idsolicitudempleo s JOIN s.Destudios de  JOIN de.idtitulo t WHERE e.id=:idempleado ORDER BY t.niveltitulo ASC")
                    ->setParameter('idempleado',$idempleado);
        $Destudios = $query2->getResult();
        
        //obtenemos los idiomas del empleado
        $query3 = $em -> createQuery("SELECT i.nombreidioma, i.nivelhabla, i.nivelescribe, i.nivellee FROM ExpedienteBundle:Empleado e JOIN e.idexpediente ex JOIN ex.idsolicitudempleo s JOIN s.Idiomas i WHERE e.id=:idempleado ")
                    ->setParameter('idempleado',$idempleado);
        $idiomas = $query3->getResult();

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Informacion Personal", "");
        return $this->render('SIGESRHIPortalEmpleadoBundle:Empleadoportal:show.html.twig', array(
            'entity'    => $entity,
            'plazas'    => $plazas,
            'Destudios' => $Destudios,
            'idiomas'   => $idiomas,
        ));
    }

    public function showlicenciasAction(){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        if($user == 'anon.'){
            return $this->redirect($this->generateUrl('hello_page'));           
        }
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();
        $contrataciones = $empleado->getIdcontratacion();
        $idcontratacion = array(0);
        foreach ($contrataciones as $contratacion) {
            $idcontratacion[] = $contratacion->getId();
        }
        $entity = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
        }

        //Obtenemos las licencias
        $source = new Entity('ExpedienteBundle:Licencia','licencias_por_contrato');
        $grid = $this->get('grid');
        $grid->setSource($source); 

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$idcontratacion){
                $query->andWhere($tableAlias.'.idcontratacion IN  (:idcontratacion)')                      
                      ->setParameter('idcontratacion',$idcontratacion);
            }
        );

         $rowAction1 = new RowAction('Ver detalle', 'empleadoportal_licencias_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);
        $grid->setId('grid_licencias_empleado');
        $grid->setDefaultOrder('fechapermiso','asc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Licencias y permisos","");
        return $grid->getGridResponse('SIGESRHIPortalEmpleadoBundle:Empleadoportal:showlicencias.html.twig');

    }

    public function detallelicenciaAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ExpedienteBundle:Licencia')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Licencia entity.');
        }
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Licencias y permisos",$this->get("router")->generate("empleadoportal_licencias"));
        $breadcrumbs->addItem($entity->getConcepto(),"");

        return $this->render('SIGESRHIPortalEmpleadoBundle:Empleadoportal:detallelicencia.html.twig', array(
            'entity'      => $entity,
            ));
    }

    public function showevaluacionesAction(){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        if($user == 'anon.'){
            return $this->redirect($this->generateUrl('hello_page'));           
        }
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();

        $evaluaciones = $em->getRepository('EvaluacionBundle:Evaluacion')->findByIdempleado($idempleado);

        if (!$evaluaciones) {
            $evaluaciones=0;
        }
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Evaluaciones","");

        return $this->render('SIGESRHIPortalEmpleadoBundle:Empleadoportal:showevaluaciones.html.twig', array(
            'evaluaciones'      => $evaluaciones,
            ));
    }

    public function ajaxevaluacionesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $idevaluacion = $request->get('periodo');
        $evaluacion = $em->getRepository('EvaluacionBundle:Evaluacion')->find($idevaluacion);        
        if (!$evaluacion) {
            $contenido = '<span id="datos_noencontrados">No se encontro evaluacion</span>';
        }
        else{
            $contenido = $this->renderView('SIGESRHIPortalEmpleadoBundle:Empleadoportal:detalleevaluacion.html.twig', array(
            'evaluacion'      => $evaluacion,
            ));
        }
        $datosrespuesta = array(
            'contenido' => $contenido,
            'error'=>'noerror',
            'status'=>'OK'
            );
        $response = new Response(json_encode($datosrespuesta));
        $response->headers->set('Content-Type', 'application/json');

        return $response;   
    }

}
