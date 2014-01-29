<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Periodoeval;
use SIGESRHI\EvaluacionBundle\Form\PeriodoevalType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Periodoeval controller.
 *
 */
class PeriodoevalController extends Controller
{
    /**
     * Lists all Periodoeval entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('EvaluacionBundle:Periodoeval', 'grupo_periodo_evaluacion');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Periodos de Evaluación", $this->get("router")->generate("periodoeval"));
        //$breadcrumbs->addItem("Consultar Solicitud de Empleo", $this->get("router")->generate("solicitud_caspirante"));
        //fin camino de miga
       
    

        // Attach the source to the grid
        $grid->setId('grid_periodo_evaluacion');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
       $grid->setDefaultOrder('anio', 'desc');
        
        $rowAction1 = new RowAction('Consultar', 'periodoeval_show');

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('EvaluacionBundle:Periodoeval:index.html.twig');
    }

    /**
     * Creates a new Periodoeval entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Periodoeval();
        $em = $this->getDoctrine()->getManager();

        $entity->setAnio( (int) date('Y'));
        $form = $this->createForm(new PeriodoevalType(), $entity);
        $form->bind($request);

        $fechaini = $entity->getFechainicio();
        $fechafin = $entity->getFechafin();
        $semestre = $entity->getSemestre();

        $fi = substr($fechaini->format('d-m-Y'),6,4);
        $ff = substr($fechafin->format('d-m-Y'),6,4);
        $fa = (string) date('Y');
        
        if(!($fi == $ff and $fi == $fa)){
            $this->get('session')->getFlashBag()->add('new_error', 'Error en fechas ingresadas. Solo puede registrar fechas del año actual.
                :'.$fa); 
            return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            ));
        }

        if( strtotime($fechaini->format('d-m-Y')) > strtotime($fechafin->format('d-m-Y'))){
            $this->get('session')->getFlashBag()->add('new_error', 'Error en fechas ingresadas. Fecha de inicio no puede ser mayor que fecha fin'); 
            return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            ));
        }

        $periodo = $em->getRepository('EvaluacionBundle:Periodoeval')->findBy(array('anio' => $fa,'semestre'=>$semestre));

        if($periodo)
        {
            $this->get('session')->getFlashBag()->add('new_error', 'Ya existe un periodo de evaluación registrado para el semestre '.$semestre.' del presente año.'); 
            return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            ));
        }

        $query_traslapadas = $em->createQuery('
            Select pe.id from EvaluacionBundle:Periodoeval pe
            where (pe.fechainicio between :fechaini and :fechafin) or (pe.fechafin between :fechaini and :fechafin)
            ')->setParameter('fechaini', $fechaini)->setParameter('fechafin', $fechafin);

        $traslapadas = $query_traslapadas->getResult();
        $numTraslapadas = count($traslapadas) ;

        if($numTraslapadas > 0){
           $this->get('session')->getFlashBag()->add('new_error', 'Las fechas ingresadas se traslapan con otro periodo de evaluación del año actual.'); 
            return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            )); 
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('new', 'Periodo de evaluación registrado correctamente.'); 
            return $this->redirect($this->generateUrl('periodoeval_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Periodoeval entity.
     *
     */
    public function newAction()
    {
         //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Periodos de Evaluación", $this->get("router")->generate("periodoeval"));
        $breadcrumbs->addItem("Nuevo Periodo", $this->get("router")->generate("periodoeval_new"));
        //fin camino de miga

        $entity = new Periodoeval();
        $form   = $this->createForm(new PeriodoevalType(), $entity);

        return $this->render('EvaluacionBundle:Periodoeval:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Periodoeval entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Periodoeval')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periodoeval entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Periodos de Evaluación", $this->get("router")->generate("periodoeval"));
        $breadcrumbs->addItem("Año ".$entity->getAnio()." - Semestre ".$entity->getSemestre(), $this->get("router")->generate("periodoeval_show",array('id'=>$id)));
        //fin camino de miga

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Periodoeval:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Periodoeval entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Periodoeval')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la entidad Periodo Evaluacion.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Periodos de Evaluación", $this->get("router")->generate("periodoeval"));
        $breadcrumbs->addItem("Año ".$entity->getAnio()." - Semestre ".$entity->getSemestre(), $this->get("router")->generate("periodoeval_show",array('id'=>$id)));
        $breadcrumbs->addItem('Modificar', $this->get("router")->generate("periodoeval_edit",array('id'=>$id)));
        //fin camino de miga


        $editForm = $this->createForm(new PeriodoevalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Periodoeval entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Periodoeval')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la entidad Periodo evaluacion.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PeriodoevalType(), $entity);
        $editForm->bind($request);

        // inicio validaciones de fechas
        $fechaini = $entity->getFechainicio();
        $fechafin = $entity->getFechafin();
        $semestre = $entity->getSemestre();
        $año = $entity->getAnio();

        echo "<br> 1. ".$fechaini->format('d-m-Y');
        echo "<br> 2. ".$fechafin->format('d-m-Y');
        echo "<br> 3. ".$semestre;
        echo "<br> 4. ".$año;

        $fi = substr($fechaini->format('d-m-Y'),6,4);
        $ff = substr($fechafin->format('d-m-Y'),6,4);
        $fa = $año;

        echo "<br>validacion 1";
        
        if(!($fi == $ff and $fi == $fa)){
            $this->get('session')->getFlashBag()->add('edit_error', 'Error en fechas ingresadas. Solo puede registrar fechas del año: '.$fa); 
            return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            ));
        }

        echo "<br>validacion 2";
        if( strtotime($fechaini->format('d-m-Y')) > strtotime($fechafin->format('d-m-Y'))){
            $this->get('session')->getFlashBag()->add('edit_error', 'Error en fechas ingresadas. Fecha de inicio no puede ser mayor que fecha fin'); 
            return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            ));
        }

        echo "<br>validacion 3";

        $periodo = $em->getRepository('EvaluacionBundle:Periodoeval')->findBy(array('anio' => $fa,'semestre'=>$semestre));

        $band=false;
        $count=0;
        foreach($periodo as $per)
        {
            if($per->getId()== $id){
                $band=true;
                }
            
            $count++;
        }
        echo "<br>".$band;
        echo "<br>".$count;


        if($periodo and ($band == true and $count > 1))
        {
            $this->get('session')->getFlashBag()->add('edit_error', 'Ya existe un periodo de evaluación registrado para el semestre '.$semestre.' del presente año.'); 
            return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            ));
        }

        echo "<br>validacion 4";

        $query_traslapadas = $em->createQuery('
            Select pe.id from EvaluacionBundle:Periodoeval pe
            where (pe.fechainicio between :fechaini and :fechafin) or (pe.fechafin between :fechaini and :fechafin)
            ')->setParameter('fechaini', $fechaini)->setParameter('fechafin', $fechafin);

        $traslapadas = $query_traslapadas->getResult();

        $count=0;
        foreach($traslapadas as $tras)
            if($tras['id']== $id)
                $count++;

        $numTraslapadas = count($traslapadas) ;
        echo "<br>validacion 4.5";
        if(($numTraslapadas - $count) > 0){
           $this->get('session')->getFlashBag()->add('edit_error', 'Las fechas ingresadas se traslapan con otro periodo de evaluación del año actual.'); 
            return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            )); 
        }
        //fin validaciones de fechas

echo "<br>validacion 5";
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('edit', 'Periodo de evaluación modificado correctamente.'); 
            return $this->redirect($this->generateUrl('periodoeval_show', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()->add('edit_error', 'Error en formulario.'); 
        return $this->render('EvaluacionBundle:Periodoeval:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Periodoeval entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Periodoeval')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Periodoeval entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('del', 'Periodo de evaluación eliminado correctamente.');
        return $this->redirect($this->generateUrl('periodoeval'));
    }

    /**
     * Creates a form to delete a Periodoeval entity by id.
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
