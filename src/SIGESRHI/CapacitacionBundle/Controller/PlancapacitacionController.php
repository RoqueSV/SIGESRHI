<?php

namespace SIGESRHI\CapacitacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\CapacitacionBundle\Entity\Plancapacitacion;
use SIGESRHI\CapacitacionBundle\Form\PlancapacitacionType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;

/**
 * Plancapacitacion controller.
 *
 */
class PlancapacitacionController extends Controller
{
    /**
     * Lists all Plancapacitacion entities.
     *
     */
    public function consultarAction()
    {
        //Consultar planes registrados
        

        $source = new Entity('CapacitacionBundle:Plancapacitacion','grupo_plancapacitacion');

        if ($this->get('security.context')->isGranted('ROLE_DIRECTOR')) {
           
           $em = $this->getDoctrine()->getManager();
           $user = new User();
           $empleado = new Empleado();
           $user = $this->get('security.context')->getToken()->getUser();
           
     
           $empleado = $user->getEmpleado(); //Id de director
           
          /* *** Obtener centro *** */
          $query = $em->createQuery(
                 "SELECT cu.id
                  FROM AdminBundle:Centrounidad cu
                  JOIN cu.idunidad uo
                  JOIN uo.idrefrenda ra
                  WHERE UPPER(ra.nombreplaza) like upper('%DIRECTOR%')
                  AND ra.idempleado =:idempleado")
                 ->setParameter('idempleado', $empleado->getId()); 
           $centros = $query->getSingleResult();

           $idcentro = $centros['id'];

        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias, $idcentro){
                $query->andWhere($tableAlias.'.tipoplan = :tipo')
                      ->andWhere('_idcentro.id = :idcentro')
                      ->setParameter('tipo','C')
                      ->setParameter('idcentro',$idcentro);
            });
        }

        else {

             //manipulando la Consulta del grid
             $tableAlias = $source->getTableAlias();
             $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoplan = :tipo')
                      ->setParameter('tipo','I');
            });

        }
        
        $grid = $this->get('grid');
           
        $grid->setId('grid_plan');
        $grid->setSource($source);              
        
    
        // Crear
        $rowAction1 = new RowAction('Consultar', 'plancapacitacion_show');
        $grid->addRowAction($rowAction1);
        
        $grid->setNoDataMessage('Actualmente no existen planes de capacitación registrados');
        $grid->setDefaultOrder('anoplan', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Consultar planes de capacitacion","");
        
        return $grid->getGridResponse('CapacitacionBundle:Plancapacitacion:index.html.twig');
    }

    public function resultadosAction()
    {
        //Consultar planes registrados

        $source = new Entity('CapacitacionBundle:Plancapacitacion','grupo_plancapacitacion');

         if ($this->get('security.context')->isGranted('ROLE_DIRECTOR')) {
           
           $em = $this->getDoctrine()->getManager();
           $user = new User();
           $empleado = new Empleado();
           $user = $this->get('security.context')->getToken()->getUser();
           
     
           $empleado = $user->getEmpleado(); //Id de director
           
          /* *** Obtener centro *** */
          $query = $em->createQuery(
                 "SELECT cu.id
                  FROM AdminBundle:Centrounidad cu
                  JOIN cu.idunidad uo
                  JOIN uo.idrefrenda ra
                  WHERE UPPER(ra.nombreplaza) like upper('%DIRECTOR%')
                  AND ra.idempleado =:idempleado")
                 ->setParameter('idempleado', $empleado->getId()); 
           $centros = $query->getSingleResult();

           $idcentro = $centros['id'];

        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias, $idcentro){
                $query->andWhere($tableAlias.'.tipoplan = :tipo')
                      ->andWhere('_idcentro.id = :idcentro')
                      ->setParameter('tipo','C')
                      ->setParameter('idcentro',$idcentro);
            });
        }

        else {

             //manipulando la Consulta del grid
             $tableAlias = $source->getTableAlias();
             $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.tipoplan = :tipo')
                      ->setParameter('tipo','I');
            });

        }
        
        $grid = $this->get('grid');
           
        $grid->setId('grid_plan');
        $grid->setSource($source);              
        
    
        // Crear
        $rowAction1 = new RowAction('Consultar', 'plan_capacitacion_resultados');
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('anoplan', 'desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Registrar resultados del plan","");
        
        return $grid->getGridResponse('CapacitacionBundle:Plancapacitacion:resultados_plan.html.twig');
    }

    public function resultadosCapacitacionAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plancapacitacion entity.');
        }

        /********* GRID CAPACITACIONES ***********/
        $source = new Entity('CapacitacionBundle:Capacitacion','grupo_capacitacion');
        
        $grid = $this->get('grid');

        /* Capacitaciones ya realizadas */
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias,$id){
                $query->andWhere($tableAlias.'.fechacapacitacion < :actual')
                      ->andWhere($tableAlias.'.estadocapacitacion <> :estado')
                       ->andWhere('_idplan.id= :id')
                      ->setParameter('actual',new \Datetime('now'))
                      ->setParameter('estado','F')
                      ->setParameter('id',$id);
            }
        );   
           
        $grid->setId('grid_capacitacion');

        $grid->setSource($source);    
        $grid->setNoDataMessage('No existen capacitaciones finalizadas');          
            
        // Crear
        $rowAction1 = new RowAction('Registrar', 'capacitacion_resultados');
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('fechacapacitacion', 'asc');
        $grid->setLimits(array(10 => '10', 20 => '20', 30 => '30'));


        /*****************************************/

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Registrar resultados del plan",$this->get("router")->generate("plan_resultados"));
        $breadcrumbs->addItem("Listado de capacitaciones",$this->get("router")->generate("plancapacitacion"));

        return $grid->getGridResponse('CapacitacionBundle:Plancapacitacion:resultados_capacitacion.html.twig',array(
                     'entity' => $entity));
    }


    /**
     * Creates a new Plancapacitacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity  = new Plancapacitacion();
        
        
        /******* DIRECTOR? ******/
        
        if ($this->get('security.context')->isGranted('ROLE_DIRECTOR') and !($this->get('security.context')->isGranted('ROLE_JEFERRHH'))) {
                  
           $user = new User();
           $empleado = new Empleado();

           $user = $this->get('security.context')->getToken()->getUser();
        
           $empleado = $user->getEmpleado(); //Id de director
           
          /* *** Obtener centro *** */
           $query = $em->createQuery(
                 "SELECT cu.id
                  FROM AdminBundle:Centrounidad cu
                  JOIN cu.idunidad uo
                  JOIN uo.idrefrenda ra
                  WHERE UPPER(ra.nombreplaza) like upper('%DIRECTOR%')
                  AND ra.idempleado =:idempleado")
                 ->setParameter('idempleado', $empleado->getId()); 
           $centros = $query->getSingleResult();

           $idcentro = $centros['id'];
           $centro = $em->getRepository('AdminBundle:Centrounidad')->find($idcentro);

           $entity->setTipoplan('C');
           $entity->setIdCentro($centro);

        }

        else {
            $entity->setTipoplan('I');
        }

        $form = $this->createForm(new PlancapacitacionType(), $entity);
        $form->bind($request);

        /***********************/
 

         if($entity->getTipoplan() == "I" )  //Comprobar año  si es institucional
        {
        //Comprobar si ya hay un plan para el año seleccionado
         $cant_anyo = $em->getRepository('CapacitacionBundle:Plancapacitacion')->comprobarAnyo($entity->getAnoplan());
        }
        if($entity->getTipoplan() == "C" )  //Comprobar año si es centro
        {
         $cant_anyo = $em->getRepository('CapacitacionBundle:Plancapacitacion')->comprobarAnyoCentro($entity->getAnoplan(),$entity->getIdcentro());
        }


        if($cant_anyo > 0){
            $this->get('session')->getFlashBag()->add('errorcreate', 'Error. Ya existe un plan registrado para el año seleccionado!');
            
            return $this->render('CapacitacionBundle:Plancapacitacion:new.html.twig', array(
               'entity' => $entity,
               'form'   => $form->createView(),
           ));
         }
       
        /* ******** Fin comprobar año ********* */

        if ($form->isValid()) {
           
            $em->persist($entity);
            $em->flush();
        
            //Mandar a pantalla de capacitaciones - Controlador
            $this->get('session')->getFlashBag()->add('aviso', 'Datos registrados correctamente.');

            $response = $this->forward('CapacitacionBundle:Capacitacion:new', array(
                        'idplan'  => $entity->getId(),
                        ));
            return $response;
        }
 
        $this->get('session')->getFlashBag()->add('error', 'Error en el registro de datos.');
        return $this->render('CapacitacionBundle:Plancapacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Plancapacitacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Plancapacitacion();
        $form   = $this->createForm(new PlancapacitacionType(), $entity);

       // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Registrar plan","");
        
        return $this->render('CapacitacionBundle:Plancapacitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plancapacitacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plancapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        /********* GRID CAPACITACIONES ***********/
        $source = new Entity('CapacitacionBundle:Capacitacion','grupo_capacitacion');
        
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias, $id){
                $query->andWhere('_idplan.id = :id')
                      ->setParameter('id',$id);
            }
        );   
           
        $grid->setId('grid_capacitacion');

        $grid->setSource($source);              
            
        // Crear
        $rowAction1 = new RowAction('Consultar', 'capacitacion_show');
        $grid->addRowAction($rowAction1);
        
        $grid->setDefaultOrder('fechacapacitacion', 'asc');
        $grid->setLimits(array(10 => '10', 20 => '20', 30 => '30'));


        /*****************************************/

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Capacitaciones", $this->get("router")->generate("pantalla_modulo",array('id'=>3)));
        $breadcrumbs->addItem("Plan de capacitaciones", $this->get("router")->generate("pantalla_capacitaciones"));
        $breadcrumbs->addItem("Consultar plan de capacitacion",$this->get("router")->generate("plancapacitacion"));
        $breadcrumbs->addItem("Listado de capacitaciones",$this->get("router")->generate("plancapacitacion"));

        /*return $this->render('CapacitacionBundle:Plancapacitacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));*/

        return $grid->getGridResponse('CapacitacionBundle:Plancapacitacion:show.html.twig',array(
                     'entity' => $entity));
    }

    /**
     * Displays a form to edit an existing Plancapacitacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plancapacitacion entity.');
        }

        $editForm = $this->createForm(new PlancapacitacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CapacitacionBundle:Plancapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Plancapacitacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plancapacitacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PlancapacitacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('plancapacitacion_edit', array('id' => $id)));
        }

        return $this->render('CapacitacionBundle:Plancapacitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Plancapacitacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CapacitacionBundle:Plancapacitacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Plancapacitacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('plancapacitacion'));
    }

    /**
     * Creates a form to delete a Plancapacitacion entity by id.
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
