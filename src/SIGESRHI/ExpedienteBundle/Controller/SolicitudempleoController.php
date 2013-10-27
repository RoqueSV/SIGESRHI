<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
use SIGESRHI\ExpedienteBundle\Entity\Datosempleo;
use SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares;
use SIGESRHI\ExpedienteBundle\Entity\Informacionacademica;
use SIGESRHI\ExpedienteBundle\Entity\Idioma;
use SIGESRHI\ExpedienteBundle\Entity\Expediente;

use SIGESRHI\ExpedienteBundle\Entity\Municipio;
use SIGESRHI\ExpedienteBundle\Entity\Departamento;
use SIGESRHI\ExpedienteBundle\Repositorio\departamentoRepository;

use SIGESRHI\ExpedienteBundle\Form\SolicitudempleoType;

/**
 * Solicitudempleo controller.
 *
 */
class SolicitudempleoController extends Controller
{
    /**
     * Lists all Solicitudempleo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Solicitudempleo')->findAll();

        return $this->render('ExpedienteBundle:Solicitudempleo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Solicitudempleo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Solicitudempleo();
        
        //establecer fechas de creacion/modificacion (para este caso las misma)
        $entity->setFecharegistro(new \Datetime(date('d-m-Y')));
        $entity->setFechamodificacion(new \Datetime(date('d-m-Y')));
        //$entity->setnumsolicitud(8);

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT (max(s.numsolicitud)+1) numsolicitud FROM ExpedienteBundle:Solicitudempleo s');
        $num = $query->getSingleResult();
        $entity->setnumsolicitud($num['numsolicitud']);

        $form = $this->createForm(new SolicitudempleoType(), $entity);
        $form->bind($request);

       
        if ($form->isValid()) {

            //creamos la instancia de expediente con la cual se relacionara la solicitud.
        $expediente = new Expediente();
        $expediente->setFechaexpediente(new \datetime(date('d-m-Y')));
        $expediente->setTipoexpediente('I');

         $em->persist($expediente);
         $em->flush();
       
       //asignamos a solicitud el id del nuevo expediente
        $entity->setIdexpediente($expediente);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Solicitudempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Solicitudempleo entity.
     *
     */
    public function newAction()
    {
        $entity = new Solicitudempleo();

        
        //empieza pruebas


     
        //agregamos datos de empleo
 /*       $datosempActual = new Datosempleo();
        $datosempActual->name = 'Empleo Actual';
        $datosempActual->setTipodatoempleo('Empleo Actual');
        $entity->getDempleos()->add($datosempActual);
 
        $datosempAnterior = new Datosempleo();
        $datosempAnterior->name = 'Empleo Anterior';
        $datosempAnterior->setTipodatoempleo('Empleo Anterior');
        $entity->getDempleos()->add($datosempAnterior);
        
*/       
        //agregamos datos familiares
        $datosFam= new Datosfamiliares();
        $datosFam->name = 'Dato Familiar 1';
        $entity->getDfamiliares()->add($datosFam);
        //termina pruebas

         //agregamos datos de estudio
        $datosEst= new Informacionacademica();
        $datosEst->name = 'Dato studio 1';
        $entity->getDestudios()->add($datosEst);
        //termina pruebas
/*
        //agregamos un Idioma
        $Idioma= new Idioma();
        $Idioma->name = 'Idioma 1';
        $entity->getIdiomas()->add($Idioma);
        //termina pruebas
   */ 
        $form   = $this->createForm(new SolicitudempleoType(), $entity);

        return $this->render('ExpedienteBundle:Solicitudempleo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Solicitudempleo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Solicitudempleo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Solicitudempleo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
        }

        $editForm = $this->createForm(new SolicitudempleoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Solicitudempleo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SolicitudempleoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Solicitudempleo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Solicitudempleo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Solicitudempleo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitudempleo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitud'));
    }

    /**
     * Creates a form to delete a Solicitudempleo entity by id.
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




    /************Funcion consultar municipios**************/

 public function consultarMunicipiosJSONAction(){

    $request = $this->getRequest();
    $idDpto = $request->get('departamento');
    //$departamDao = new DepartamentoRepository($this->getDoctrine());
    //$municipios = $departamDao->consultarMunicipioDpto($idDpto);
    $em=$this->getDoctrine()->getEntityManager(); //agregado
    $departamDao = $em->getRepository('ExpedienteBundle:Departamento')->find($idDpto); //agregado
    $municipios = $departamDao->getMunicipios();  //agregado
   
    $numfilas = count($municipios);

    $muni = new Municipio();
    $i = 0;

    foreach ($municipios as $muni){
        $rows[$i]['id'] = $muni->getId();
        $rows[$i]['cell'] = array($muni->getId(), 
            $muni->getNombremunicipio(),
            $muni->getIddepartamento());
        $i++;
    }

    $datos = json_encode($rows);
    $pages = floor($numfilas / 10) +1;

    $jsonresponse = '{
        "page":"1",
        "total":"'.$pages.'",
        "records":"'.$numfilas.'",
        "rows":'.$datos.'}';

        $response= new Response($jsonresponse);
        return $response;
}//fin funcion


}//fin clase



