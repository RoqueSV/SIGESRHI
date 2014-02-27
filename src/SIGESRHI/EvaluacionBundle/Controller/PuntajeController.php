<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Puntaje;
use SIGESRHI\EvaluacionBundle\Form\PuntajeType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\TextColumn;

/**
 * Puntaje controller.
 *
 */
class PuntajeController extends Controller
{
    /**
     * Lists all Puntaje entities.
     *
     */
    public function indexAction()
    {
       $source = new Entity('EvaluacionBundle:Puntaje', 'grupo_puntaje');
        // Get a grid instance
        $grid = $this->get('grid');

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        //fin camino de miga
       

        // Attach the source to the grid
        $grid->setId('grid_puntajes');
        $grid->setSource($source);

        $em = $this->getDoctrine()->getManager();
          
        $grid->setNoDataMessage("No se encontraron resultados");
        $grid->setDefaultOrder('id', 'asc');
        
        $rowAction1 = new RowAction('Consultar', 'puntaje_show');

        $rowAction1->setColumn('info_column');

        $grid->addRowAction($rowAction1);     
        //$grid->addExport(new ExcelExport('Exportar a Excel'));
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));

    // Manage the grid redirection, exports and the response of the controller
    return $grid->getGridResponse('EvaluacionBundle:Puntaje:index.html.twig');
    }

    /**
     * Creates a new Puntaje entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Puntaje();
        $form = $this->createForm(new PuntajeType(), $entity);
        $form->bind($request);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        $breadcrumbs->addItem("Registrar Puntaje", $this->get("router")->generate("puntaje_new"));
        //fin camino de miga

        //verificar que los puntajes vienen en el orden correcto
        if($entity->getPuntajemin() > $entity->getPuntajemax()){
            $this->get('session')->getFlashBag()->add('msg-error','El puntaje minimo ingresado no debe ser mayor que el puntaje máximo.');
            return $this->render('EvaluacionBundle:Puntaje:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
        }

        //verificar que datos ingresados de puntajes no se traslapen con otros ya existentes
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
          SELECT p.id, p.nombrepuntaje
          FROM EvaluacionBundle:Puntaje p
          WHERE (:puntajemin between p.puntajemin and p.puntajemax) or (:puntajemax between p.puntajemin and p.puntajemax)'
        )->setParameter('puntajemin', $entity->getPuntajemin())->setParameter('puntajemax', $entity->getPuntajemax());  

        $resul = $query->getResult();
        $numResul = count($resul);

        if($numResul > 0){
            $this->get('session')->getFlashBag()->add('msg-error','Los datos de puntaje ingresados se traslapan con un registro existente: '.$resul[0]['nombrepuntaje']);
            return $this->render('EvaluacionBundle:Puntaje:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg','Datos de puntaje registrados correctamente.');
            return $this->redirect($this->generateUrl('puntaje_show', array('id' => $entity->getId())));
        }

        return $this->render('EvaluacionBundle:Puntaje:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Puntaje entity.
     *
     */
    public function newAction()
    {
        $entity = new Puntaje();
        $form   = $this->createForm(new PuntajeType(), $entity);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        $breadcrumbs->addItem("Registrar Puntaje", $this->get("router")->generate("puntaje_new"));
        //fin camino de miga

        return $this->render('EvaluacionBundle:Puntaje:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Puntaje entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Puntaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Puntaje entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        $breadcrumbs->addItem($entity->getNombrepuntaje(), $this->get("router")->generate("puntaje_show", array('id'=>$id)));
        //fin camino de miga
       

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('EvaluacionBundle:Puntaje:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Puntaje entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Puntaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Puntaje entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        $breadcrumbs->addItem($entity->getNombrepuntaje(), $this->get("router")->generate("puntaje_show", array('id'=>$id)));
        $breadcrumbs->addItem("Modificar", $this->get("router")->generate("puntaje_edit", array('id'=>$id)));
        //fin camino de miga

        $editForm = $this->createForm(new PuntajeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('EvaluacionBundle:Puntaje:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Puntaje entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Puntaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Puntaje entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Puntajes", $this->get("router")->generate("puntaje"));
        $breadcrumbs->addItem($entity->getNombrepuntaje(), $this->get("router")->generate("puntaje_show", array('id'=>$id)));
        $breadcrumbs->addItem("Modificar", $this->get("router")->generate("puntaje_edit", array('id'=>$id)));
        //fin camino de miga


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PuntajeType(), $entity);
        $editForm->bind($request);

        //verificar que los puntajes vienen en el orden correcto
        if($entity->getPuntajemin() > $entity->getPuntajemax()){
            $this->get('session')->getFlashBag()->add('msg-error','El puntaje minimo ingresado no debe ser mayor que el puntaje máximo.');
            return $this->render('EvaluacionBundle:Puntaje:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        }

        //validar puntaje min y maximo no se traslapen
        //verificar que datos ingresados de puntajes no se traslapen con otros ya existentes
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
          SELECT p.id, p.nombrepuntaje
          FROM EvaluacionBundle:Puntaje p
          WHERE ((:puntajemin between p.puntajemin and p.puntajemax) or (:puntajemax between p.puntajemin and p.puntajemax)) and p.id !=:idactual'
        )->setParameter('puntajemin', $entity->getPuntajemin())
        ->setParameter('puntajemax', $entity->getPuntajemax())
        ->setParameter('idactual', $id);  

        $resul = $query->getResult();
        $numResul = count($resul);

        if($numResul > 0){
            $this->get('session')->getFlashBag()->add('msg-error','Los datos de puntaje ingresados se traslapan con un registro existente: '.$resul[0]['nombrepuntaje']);
            return $this->render('EvaluacionBundle:Puntaje:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        }


        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg','Datos de puntaje modificados correctamente.');
            return $this->redirect($this->generateUrl('puntaje_show', array('id' => $id)));
        }

        return $this->render('EvaluacionBundle:Puntaje:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Puntaje entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Puntaje')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Puntaje entity.');
            }

            $num = count($entity->getIdformulario());
            //si la cantidad de asociacion con formulario es mayor a 0
            if($num > 0){
                 $this->get('session')->getFlashBag()->add('msg-error','Puntaje esta asociado a formulario, no se puede eliminar.');
            return $this->redirect($this->generateUrl('puntaje_show', array('id' => $id)));
            }            

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('puntaje'));
    }

    /**
     * Creates a form to delete a Puntaje entity by id.
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
