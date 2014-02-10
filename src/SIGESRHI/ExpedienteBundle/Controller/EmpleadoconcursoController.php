<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;
use SIGESRHI\ExpedienteBundle\Form\EmpleadoconcursoType;

/**
 * Empleadoconcurso controller.
 *
 */
class EmpleadoconcursoController extends Controller
{
    
    /**
     * Creates a new Empleadoconcurso entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Empleadoconcurso();
        $form = $this->createForm(new EmpleadoconcursoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //Verificar si empleado ya participa en el concurso
            $query=$em->createQuery('SELECT COUNT(e.id) AS numemp FROM ExpedienteBundle:Empleado e
            join e.idempleadoconcurso ec
             WHERE e.id = :idempleado AND ec.idconcurso =:idconcurso' 
             )->setParameter('idempleado', $entity->getIdempleado()->getId())
              ->setParameter('idconcurso', $request->get('idconcurso'));
            $resultado = $query->getSingleResult();

            $num=$resultado['numemp'];

            if($num != 0){
                // Incluimos camino de migas
                $breadcrumbs = $this->get("white_october_breadcrumbs");
                $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
                $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
                $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
                $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$request->get('idconcurso'))));
                $breadcrumbs->addItem("Registrar empleado", $this->get("router")->generate("concurso_consultar"));


                $this->get('session')->getFlashBag()->add('error', 'Error. El empleado seleccionado ya se encuentra participando en este concurso.');
                return $this->render('ExpedienteBundle:Empleadoconcurso:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'id'     => $request->get('idconcurso'),
            ));

            } //Fin verificar empleado

            $concurso = $em->getRepository('ExpedienteBundle:Concurso')->find($request->get('idconcurso'));

            $entity->setIdconcurso($concurso);

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('aviso', 'Empleado registrado correctamente.');
            return $this->redirect($this->generateUrl('detalle_concurso', array('id' =>  $request->get('idconcurso'))));
        }

        return $this->render('ExpedienteBundle:Empleadoconcurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'     => $request->get('idconcurso'),
        ));
    }

    /**
     * Displays a form to create a new Empleadoconcurso entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $entity = new Empleadoconcurso();
        $entity->setFecharegistro(new \Datetime(date('d-m-Y')));

        $form   = $this->createForm(new EmpleadoconcursoType(), $entity);
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
        $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$request->get('id'))));
        $breadcrumbs->addItem("Registrar empleado", $this->get("router")->generate("concurso_consultar"));

        return $this->render('ExpedienteBundle:Empleadoconcurso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'     => $request->get('id'),
        ));
    }

    /**
     * Finds and displays a Empleadoconcurso entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Empleadoconcurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleadoconcurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

         // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Promoción de personal", $this->get("router")->generate("pantalla_modulo",array('id'=>2)));
        $breadcrumbs->addItem("Consultar concurso interno", $this->get("router")->generate("concurso_consultar"));
        $breadcrumbs->addItem("Información de concurso", $this->get("router")->generate("detalle_concurso",array('id'=>$entity->getIdconcurso()->getId())));
        $breadcrumbs->addItem("Ver documentación empleado", $this->get("router")->generate("concurso_consultar"));
        
        /* Obtener plaza (s) actuales del empleado */
        $query=$em->createQuery('SELECT p.nombreplaza FROM ExpedienteBundle:Empleado e
        join e.idrefrenda r
        join r.idplaza p
        WHERE e.id = :idempleado'
        )->setParameter('idempleado', $entity->getIdempleado()->getId());
        $plazas = $query->getResult();

        /* ************* */     

        if($entity->getDocconcurso() != null){
          $extension=substr($entity->getDocconcurso(),-3,3);
        

        return $this->render('ExpedienteBundle:Empleadoconcurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'extension'   => $extension,
            'plazas'      => $plazas,        ));
        }

        return $this->render('ExpedienteBundle:Empleadoconcurso:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'plazas'      => $plazas,    ));
    }

    /**
     * Deletes a Empleadoconcurso entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        /*$form = $this->createDeleteForm($id);
        $form->bind($request);*/

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Empleadoconcurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Empleadoconcurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        $this->get('session')->getFlashBag()->add('delete', 'Registro eliminado correctamente.');
        return $this->redirect($this->generateUrl('detalle_concurso',
               array('id'=>$request->get('idconcurso'))));
    }

    /**
     * Creates a form to delete a Empleadoconcurso entity by id.
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
