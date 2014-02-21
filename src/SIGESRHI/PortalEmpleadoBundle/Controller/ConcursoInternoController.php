<?php

namespace SIGESRHI\PortalEmpleadoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Concurso;
use SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use Application\Sonata\UserBundle\Entity\User;

use SIGESRHI\PortalEmpleadoBundle\Form\ConcursoempleadoType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Concurso controller.
 *
 */
class ConcursoInternoController extends Controller
{


public function consultarAction()
    {
        $source = new Entity('ExpedienteBundle:Concurso','grupo_concurso');
        
        $grid = $this->get('grid');
        
        $grid->hideColumns('codigoconcurso');

        /* Concursos vigentes */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.fechacierre >= :actual')
                      ->setParameter('actual', new \Datetime('now'));
            }
        );   

           
        $grid->setId('grid_concurso');
        $grid->setSource($source);              
        
        $NombrePlazas = new TextColumn(array('id' => 'plazas','source' => true,'field'=>'idplaza.nombreplaza','title' => 'Nombre plaza','operatorsVisible'=>false,'joinType'=>'inner'));
        $grid->addColumn($NombrePlazas,3);   

        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'concurso_empleado_detalle');
        $grid->addRowAction($rowAction1);
        
        $grid->setNoDataMessage('Actualmente no existen concursos internos hábiles');
        $grid->setDefaultOrder('fechacierre', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aplicar a plaza vacante", $this->get("router")->generate("concurso_empleado_consultar"));
        
        return $grid->getGridResponse('SIGESRHIPortalEmpleadoBundle:ConcursoInterno:concursos_disponibles.html.twig');
    }



    public function detalleConcursoAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $idconcurso = $request->get('id');

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($idconcurso);

        $empleadoconcurso = new Empleadoconcurso();
        $form   = $this->createForm(new ConcursoempleadoType(), $empleadoconcurso);
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Aplicar a plaza vacante", $this->get("router")->generate("concurso_empleado_consultar"));
        $breadcrumbs->addItem("Detalle concurso", $this->get("router")->generate("concurso_empleado_detalle"));
        
        return $this->render('SIGESRHIPortalEmpleadoBundle:ConcursoInterno:detalle_concurso.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {

        //Obtenemos el id de empleado del usuario logueado
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();

        //validamos que el usuario este logueado
        if($user== "anon.")
        {
            throw $this->createNotFoundException('Inicie sesión para acceder a esta página');
        }
        
        $idempleado = $user->getEmpleado()->getId();

        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository('ExpedienteBundle:Empleado')->find($idempleado);

        //Consurso
        $concurso = $em->getRepository('ExpedienteBundle:Concurso')->find($request->get('idconcurso'));

        $entity  = new Empleadoconcurso();
        $form = $this->createForm(new ConcursoempleadoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //Verificar si empleado ya participa en el concurso
            $query=$em->createQuery('SELECT COUNT(e.id) AS numemp 
                                     FROM ExpedienteBundle:Empleado e
                                     join e.idempleadoconcurso ec
                                     WHERE e.id = :idempleado AND ec.idconcurso =:idconcurso' 
                                   )
                      ->setParameter('idempleado', $idempleado)
                      ->setParameter('idconcurso', $request->get('idconcurso'));
            
            $resultado = $query->getSingleResult();
            $num=$resultado['numemp'];

            if($num != 0){
                $this->get('session')->getFlashBag()->add('error', 'Error. Ya realizó una aplicación para este concurso.');
                return $this->redirect($this->generateUrl('concurso_empleado_detalle',array('id'=>$concurso->getId())));

            } //Fin verificar empleado


            $entity->setIdconcurso($concurso);
            $entity->setIdEmpleado($empleado);
            $entity->setFecharegistro(new \Datetime('now'));

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Aplicación a concurso registrada correctamente.');
            return $this->redirect($this->generateUrl('concurso_empleado_detalle',array('id'=>$concurso->getId())));
        
        }//ifValid

        return $this->render('SIGESRHIPortalEmpleadoBundle:ConcursoInterno:detalle_concurso.html.twig', array(
                'entity' => $concurso,
                'form'   => $form->createView(),
            ));
    }

}