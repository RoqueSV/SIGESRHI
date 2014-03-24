<?php

namespace SIGESRHI\EvaluacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion;
use SIGESRHI\EvaluacionBundle\Entity\Opcion;
use SIGESRHI\EvaluacionBundle\Form\FactorevaluacionType;

/**
 * Factorevaluacion controller.
 *
 */
class FactorevaluacionController extends Controller
{
   
    //Guarda en la BD los datos del factor y opciones ingresadas
    public function createFactorAction(Request $request)
    {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            
            $fevaluacion = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

            if (!$fevaluacion) {
                throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
                }
    
        $entity  = new Factorevaluacion();
        $entity->setIdformulario($fevaluacion);
        $form = $this->createForm(new FactorevaluacionType(), $entity);
        $form->bind($request);

        //Guardamos en un array los nombres de las opciones ingresadas
        $nopcion_array = array();
        foreach($entity->getOpciones() as $opcion)
        {
            $nopcion_array[]= $opcion->getNombreopcion();

        }
        //comprobamos si las opciones se repiten con la funcion "compruebaOpciones"
        if($this->compruebaOpciones($nopcion_array))
        {
               //camino de miga
            $breadcrumbs = $this->get("white_october_breadcrumbs");
            $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
            $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
            $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
            $breadcrumbs->addItem($fevaluacion->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$id)));
            $breadcrumbs->addItem("Factores", $this->get("router")->generate("hello_page"));
            //fin camino de miga
    
            $this->get('session')->getFlashBag()->add('msg-error', 'NO pueden haber opciones repetidas en el factor de evaluación.'); 
            return $this->render('EvaluacionBundle:Factorevaluacion:new.html.twig', array(
                'factorevaluacion' => $entity,
                'form'   => $form->createView(),
                'fevaluacion'=>$fevaluacion,
            ));
        }//if compruebapciones()
       


        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg', 'Factor de evaluación registrado correctamente.'); 
            return $this->redirect($this->generateUrl('factorevaluacion_newfactor', array('id' => $fevaluacion->getId())));
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
        $breadcrumbs->addItem($fevaluacion->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$id)));
        $breadcrumbs->addItem("Factores", $this->get("router")->generate("hello_page"));
        //fin camino de miga
    
        $this->get('session')->getFlashBag()->add('msg-error', 'Error en el factor de evaluación.'); 
        return $this->render('EvaluacionBundle:Factorevaluacion:new.html.twig', array(
            'factorevaluacion' => $entity,
            'form'   => $form->createView(),
            'fevaluacion'=>$fevaluacion,
        ));
    
    }

    
    //crea el formulario para el registro de un nuevo factor y sus opciones
    public function newFactorAction($id)
    {
        $factorevaluacion = new Factorevaluacion();
        $Opciones = new Opcion();
        $factorevaluacion->getOpciones()->add($Opciones);
        $factor_form   = $this->createForm(new FactorevaluacionType(), $factorevaluacion);
        
        $em = $this->getDoctrine()->getManager();
        $fevaluacion = $em->getRepository('EvaluacionBundle:Formularioevaluacion')->find($id);

        if (!$fevaluacion) {
            throw $this->createNotFoundException('Unable to find Formularioevaluacion entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
        $breadcrumbs->addItem($fevaluacion->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$id)));
        $breadcrumbs->addItem("Factores", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        return $this->render('EvaluacionBundle:Factorevaluacion:new.html.twig', array(
            'factorevaluacion' => $factorevaluacion,
            'form'   => $factor_form->createView(),
            'fevaluacion'=> $fevaluacion,
        ));
    }


     //recupera los datos de un factor para mostrarse en la vista
    public function showFactorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

         //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
        $breadcrumbs->addItem($entity->getIdformulario()->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem("Factores", $this->get("router")->generate("factorevaluacion_newfactor", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem(substr($entity->getNombrefactor(),0,10)."..", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('EvaluacionBundle:Factorevaluacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Factorevaluacion entity.
     *
     */
    public function editFactorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

        $editForm = $this->createForm(new FactorevaluacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
        $breadcrumbs->addItem($entity->getIdformulario()->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem("Factores", $this->get("router")->generate("factorevaluacion_newfactor", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem(substr($entity->getNombrefactor(),0,10)."..", $this->get("router")->generate("factorevaluacion_showfactor", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem("Modificar", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        return $this->render('EvaluacionBundle:Factorevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    //Actualiza los datos modificados
    public function updateFactorAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
        }

        //camino de miga
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Evaluación de desempeño", $this->get("router")->generate("pantalla_modulo",array('id'=>4)));
        $breadcrumbs->addItem("Formularios de evaluación", $this->get("router")->generate("formularioevaluacion"));
        $breadcrumbs->addItem($entity->getIdformulario()->getNombrebreve(), $this->get("router")->generate("formularioevaluacion_show", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem("Factores", $this->get("router")->generate("factorevaluacion_newfactor", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem(substr($entity->getNombrefactor(),0,10)."..", $this->get("router")->generate("factorevaluacion_showfactor", array('id'=>$entity->getIdformulario()->getId())));
        $breadcrumbs->addItem("Modificar", $this->get("router")->generate("hello_page"));
        //fin camino de miga

        //* Para eliminar Opciones (son embebidos)
         //creamos un arreglo de los objetos Opciones
        $originalOpciones = array();
        foreach ($entity->getOpciones() as $Opcion) {
           $originalOpciones[] = $Opcion;
         }
         //obtenemos el numero de opciones registradas del factor
         $numOpciones = count($entity->getOpciones());

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FactorevaluacionType(), $entity);
        $editForm->bind($request);

//////*********************** COMPROBACION DE N REPETICION DE OPCIONES***********//////
        //Guardamos en un array los nombres de las opciones ingresadas
        $nopcion_array = array();
        foreach($entity->getOpciones() as $opcion)
        {
            $nopcion_array[]= $opcion->getNombreopcion();

        }
        //comprobamos si las opciones se repiten con la funcion "compruebaOpciones"
        if($this->compruebaOpciones($nopcion_array))
        {    
             $this->get('session')->getFlashBag()->add('msg-error','NO pueden haber opciones repetidas en el factor de evaluación.'); 
        return $this->render('EvaluacionBundle:Factorevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        }//if compruebapciones()
//////***********************---------------------------------------------***********//////

        if ($editForm->isValid()) {

             /*   Bloque de eliminacion de las Opciones */
            foreach ($entity->getOpciones() as $Opcion) {
                foreach ($originalOpciones as $key => $toDel) {
                    if ($toDel->getId() === $Opcion->getId()) {
                        unset($originalOpciones[$key]);
                    }
                }
            }

            // Elimina la relación entre Opciones y Factorevaluacion
            foreach ($originalOpciones as $Opcion) {

                     if(count($Opcion->getRespuestas()) > 0)
                        {
                            $this->get('session')->getFlashBag()->add('msg-error','No se puede eliminar la opcion: '.$Opcion->getNombreopcion(). " Tiene asociadas evaluaciones realizadas."); 
                            return $this->redirect($this->generateUrl('factorevaluacion_editfactor', array('id' => $id)));
                        }
                     $Opcion->setIdfactor(null);
                     $em->remove($Opcion);
             }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg','Modificación a factor realizada correctamente.'); 
            return $this->redirect($this->generateUrl('factorevaluacion_showfactor', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()->add('msg-error','Error en la modificación del factor.'); 
        return $this->render('EvaluacionBundle:Factorevaluacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Factorevaluacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvaluacionBundle:Factorevaluacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Factorevaluacion entity.');
            }

            //verificar que el factor no tenga relacioes con la tabla respuesta
            $numRespuesta = count($entity->getRespuestas());
            if($numRespuesta > 0 ){
                $this->get('session')->getFlashBag()->add('msg-error','No se puede eliminar, el factor esta asociado a evaluaciones realizadas.');
                return $this->redirect($this->generateUrl('factorevaluacion_showfactor',array('id'=>$id)));
            }

            $idform=$entity->getIdformulario()->getId();
            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg','Factor eliminado correctamente.');
        }

        return $this->redirect($this->generateUrl('factorevaluacion_newfactor',array('id'=>$idform)));
    }

    /**
     * Creates a form to delete a Factorevaluacion entity by id.
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


    //funcion utilizada para comprobar que los nombres seleccionados de las opciones de un factor de evaluacion no se repitan
    //Recibe un array conteniendo solo los nombres de las opciones
    public function compruebaOpciones($array)
    {
        $bandera= false;
        for($i=0; $i< count($array); $i++)
        {
            $cont=0;
            for($j=0; $j < count($array); $j++)
            {
                if($array[$i] == $array[$j]){
                    $cont++;
                }
            }
            if($cont > 1)
            {
                $bandera=true;
            }
        }
        return $bandera;
    }//function

}
