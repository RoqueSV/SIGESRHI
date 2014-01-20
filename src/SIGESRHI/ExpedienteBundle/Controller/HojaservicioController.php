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
        
        $this->get('session')->getFlashBag()->add('aviso', 'Hoja de servicio registrada correctamente.');
        return $this->redirect($this->generateUrl('contratacion_show', array('id' => $request->get('idcontratacion'),
                                                                             'tipo'=>$request->get('tipo'))));
        }

        return $this->render('ExpedienteBundle:Hojaservicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fotografia' => $request->get('fotografia'),
            'idexp'=>$request->get('idexp'),
            'idcontratacion'=>$request->get('idcontratacion'),
        ));
    }

    /**
     * Displays a form to create a new Hojaservicio entity.
     *
     */
    public function newAction($id,$idc)
    {
        $entity = new Hojaservicio();
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

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
                 SELECT r.nombreplaza, ca.nombrecentro
                 FROM ExpedienteBundle:Contratacion c
                 JOIN c.puesto r
                 JOIN r.idunidad u
                 JOIN u.idcentro ca
                 WHERE c.id = :id'
                 )
        ->setMaxResults(1)
        ->setParameter('id', $contratacion->getId());
 
        $plazaunidad = $query->getResult();  

        foreach ($plazaunidad as $pu) {
          $cargo = $pu['nombreplaza']; 
          $centro = $pu['nombrecentro']; 
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
        $entity->setDestacadoen($centro);

        $form   = $this->createForm(new HojaservicioType(), $entity);
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Expediente", $this->get("router")->generate("pantalla_modulo",array('id'=>1)));
        $breadcrumbs->addItem("Aspirante", $this->get("router")->generate("pantalla_aspirante"));
        $breadcrumbs->addItem("Registrar aspirante como empleado", $this->get("router")->generate("contratacion"));
        $breadcrumbs->addItem("Registrar hoja de servicio / ".$solicitud->getNombrecompleto(),  $this->get("router")->generate("hello_page"));

        return $this->render('ExpedienteBundle:Hojaservicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fotografia' => $fotografia,
            'idexp'=>$id,
            'idcontratacion'=>$idc,
            'tipo' =>$request->get('tipo'),
        ));
    }

    
}
