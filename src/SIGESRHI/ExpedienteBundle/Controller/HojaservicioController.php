<?php

namespace SIGESRHI\ExpedienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\ExpedienteBundle\Entity\Hojaservicio;
use SIGESRHI\ExpedienteBundle\Entity\Contratacion;
use SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo;
use SIGESRHI\ExpedienteBundle\Form\HojaservicioType;

/**
 * Hojaservicio controller.
 *
 */
class HojaservicioController extends Controller
{
    /**
     * Lists all Hojaservicio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExpedienteBundle:Hojaservicio')->findAll();

        return $this->render('ExpedienteBundle:Hojaservicio:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Hojaservicio entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Hojaservicio();
        $idexp=$request->get('idexp');

        //Asignar expediente a la hoja de servicio
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('ExpedienteBundle:Expediente')->find($idexp);

        $entity->setIdexpediente($expediente);

        $form = $this->createForm(new HojaservicioType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hojaservicio_show', array('id' => $entity->getId())));
        }

        return $this->render('ExpedienteBundle:Hojaservicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Hojaservicio entity.
     *
     */
    public function newAction($id)
    {
        $entity = new Hojaservicio();
        $em = $this->getDoctrine()->getManager();

        $empleado = $em->getRepository('ExpedienteBundle:Empleado')->findOneByIdexpediente($id);
        $contratacion = $em->getRepository('ExpedienteBundle:Contratacion')->findOneByIdempleado($empleado);
        $solicitud = $em->getRepository('ExpedienteBundle:Solicitudempleo')->findOneByIdexpediente($id);

        //Obtener titulo de mayor nivel
        $query = $em->createQuery('
                 SELECT t.nombretitulo FROM ExpedienteBundle:Titulo t
                 JOIN t.idinformacionacademica i
                 JOIN i.idsolicitudempleo s
                 WHERE s.id = :id
                 ORDER BY t.niveltitulo DESC'
                 )
        ->setMaxResults(1)
        ->setParameter('id', $solicitud->getId());
 
        $titulo = $query->getResult();  

        foreach ($titulo as $t) {
          $educacion = $t['nombretitulo']; 
        }

        //Obtener plaza y unidad
        $query = $em->createQuery('
                 SELECT p.nombreplaza, u.nombreunidad
                 FROM AdminBundle:Plaza p
                 JOIN p.idcontratacion c
                 JOIN c.idunidad u
                 WHERE c.id = :id'
                 )
        ->setMaxResults(1)
        ->setParameter('id', $contratacion->getId());
 
        $plazaunidad = $query->getResult();  

        foreach ($plazaunidad as $pu) {
          $cargo = $pu['nombreplaza']; 
          $unidad = $pu['nombreunidad']; 
        } 

        //Obtener ruta de fotografia
        $fotografia = $solicitud->getFotografia();
         
        //Llenamos la hoja de servicio        
        $entity->setNombreempleado($solicitud->getNombrecompleto());
        $entity->setDui($solicitud->getDui());
        $entity->setLugardui($solicitud->getLugardui());
        $entity->setLugarnac($solicitud->getLugarnac());
        $entity->setFechanac($solicitud->getFechanac());
        $entity->setEstadocivil($solicitud->getEstadocivil());
        $entity->setDireccion($solicitud->getIdmunicipio().", ".$solicitud->getIdmunicipio()->getIddepartamento());
        $entity->setTelefonofijo($solicitud->getTelefonofijo());
        $entity->setEducacion($educacion);
        $entity->setFechaingreso($contratacion->getFechaautorizacion());
        $entity->setCargo($cargo);
        $entity->setSueldoinicial($contratacion->getSueldoinicial());
        $entity->setIsss($solicitud->getIsss());
        $entity->setNit($solicitud->getNit());
        $entity->setDestacadoen($unidad);

        $form   = $this->createForm(new HojaservicioType(), $entity);

        return $this->render('ExpedienteBundle:Hojaservicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fotografia' => $fotografia,
            'idexp'=>$id,
        ));
    }

    /**
     * Finds and displays a Hojaservicio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Hojaservicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojaservicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Hojaservicio:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Hojaservicio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Hojaservicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojaservicio entity.');
        }

        $editForm = $this->createForm(new HojaservicioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ExpedienteBundle:Hojaservicio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Hojaservicio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExpedienteBundle:Hojaservicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojaservicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new HojaservicioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hojaservicio_edit', array('id' => $id)));
        }

        return $this->render('ExpedienteBundle:Hojaservicio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Hojaservicio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExpedienteBundle:Hojaservicio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Hojaservicio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hojaservicio'));
    }

    /**
     * Creates a form to delete a Hojaservicio entity by id.
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
