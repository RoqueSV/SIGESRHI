<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Concurso;
use SIGESRHI\AdminBundle\Entity\Plaza;
use SIGESRHI\ExpedienteBundle\Form\ConcursoType;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

/**
 * Concurso controller.
 *
 */
class ConcursoController extends Controller
{
    /**
     * Lists all Concurso entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('AdminBundle:Plaza','grupo_plaza');
        
        $grid = $this->get('grid');
           
        $grid->setId('grid_concurso');
        $grid->setSource($source);              
        
    
        // Crear
        $rowAction1 = new RowAction('Seleccionar', 'concurso_new');
        $grid->addRowAction($rowAction1);
        
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("concurso"));
        $breadcrumbs->addItem("Seleccionar plaza", $this->get("router")->generate("concurso"));
        
        return $grid->getGridResponse('ExpedienteBundle:Concurso:index.html.twig');
    }

    /**
     * Creates a new Concurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $plaza = $em->getRepository('AdminBundle:Plaza')->find($request->get('plaza'));
        
        $entity  = new Concurso();
        $form = $this->createForm(new ConcursoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $entity->setIdplaza($plaza);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('concurso_show', array(
                'id' => $entity->getId(),
                'interesados' => $request->get('interesados'),)));
        }

        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'interesados' => $request->get('interesados'),
        ));
    }

    /**
     * Displays a form to create a new Concurso entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        
        $plaza = $em->getRepository('AdminBundle:Plaza')->find($request->get('id'));
        $codigoconcurso = $this->asignarCodConcurso();

        $entity = new Concurso();

        $entity->setCodigoconcurso($codigoconcurso);
        $entity->setFechaapertura(new \Datetime(date('d-m-Y')));

        /* Fecha cierre */
        $fechaactual = date_format($entity->getFechaapertura(), 'Y-m-d');
        if( strftime("%A", strtotime($fechaactual)) == 'Monday' or strftime("%A", strtotime($fechaactual)) == 'Tuesday') 
        {
          $fechacierre = date("m/d/Y", strtotime(date('d-m-Y') ."+10 day"));  
        }
        else{
          $fechacierre = date("m/d/Y", strtotime(date('d-m-Y') ."+12 day"));  
        }

        $entity->setFechacierre(new \Datetime($fechacierre));
        /*  ----------- */
        $form   = $this->createForm(new ConcursoType(), $entity);

        return $this->render('ExpedienteBundle:Concurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'plaza'  => $plaza,
        ));
    }

    /**
     * Finds and displays a Concurso entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Concurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),  
            'interesados' => $request->get('interesados'),      ));
    }

    /**
     * Displays a form to edit an existing Concurso entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $editForm = $this->createForm(new ConcursoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'interesados' => $request->get('interesados'),
        ));
    }

    /**
     * Edits an existing Concurso entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        echo $request->get('plaza');
        $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ConcursoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('concurso_show', array(
                                                      'id' => $id,
                                                      'interesados' => $request->get('interesados'),)));

            //return $this->redirect($this->generateUrl('concurso_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Concurso:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'interesados' => $request->get('interesados'),
        ));
    }

    /**
     * Deletes a Concurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Concurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Concurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('concurso'));
    }

    /**
     * Creates a form to delete a Concurso entity by id.
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

    public function asignarCodConcurso(){

        $em = $this->getDoctrine()->getManager();
        
        //conocer correlativo
        $query = $em->createQuery("SELECT COUNT(c.codigoconcurso) AS  codigo 
        FROM ExpedienteBundle:Concurso c 
        where  substring(c.codigoconcurso,locate('/',c.codigoconcurso)+1, 4) = :actual")
       ->setParameter('actual', date('Y'));

        $resultado = $query->getsingleResult();

        $num=$resultado['codigo'];

        if($num==0){

            $codigo="C.I.-001/".date('Y');
        }
        if($num > 0){
            $num++;
            $codigo = "C.I.-".str_pad($num, 3, "0", STR_PAD_LEFT)."/".date('Y');
        }
        return $codigo;

    }//fin funcion
}
