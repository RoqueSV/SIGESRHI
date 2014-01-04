<?php

namespace SIGESRHI\ExpedienteBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Repositorio\ExpedienteRepository")
 * @GRID\Source(columns="id,idempleado.codigoempleado,idsolicitudempleo.nombrecompleto,idempleado.idrefrenda.idplaza.nombreplaza, tipoexpediente,idsegurovida.id", groups={"grupo_segurovida"})
 * @GRID\Source(columns="id,idempleado.codigoempleado,idsolicitudempleo.nombrecompleto", groups={"grupo_empleado_inactivo"})
 * @GRID\Source(columns="id,idsolicitudempleo.nombrecompleto,tipoexpediente", groups={"grupo_contratacion_aspirante"})
 * @GRID\Source(columns="id,tipoexpediente,idempleado.idcontratacion.puesto.idplaza.nombreplaza,idempleado.idcontratacion.id", groups={"grupo_contratacion_consultar"})
 * @GRID\Source(columns="id,tipoexpediente,idempleado.idrefrenda.idplaza.nombreplaza", groups={"grupo_contratacion_empleado"})
 * @GRID\Source(columns="id,idsolicitudempleo.numsolicitud, idsolicitudempleo.nombrecompleto, idsolicitudempleo.fecharegistro, tipoexpediente", groups={"grupo_docdigital"})
 * @GRID\Source(columns="id,idsolicitudempleo.nombrecompleto, idsolicitudempleo.id, tipoexpediente, idempleado.codigoempleado", groups={"grupo_solicitud_empleado"})
 * @GRID\Source(columns="id,idsolicitudempleo.nombrecompleto, tipoexpediente, idempleado.codigoempleado, idempleado.idrefrenda.idplaza.nombreplaza", groups={"grupo_acciones_empleado"})
 * @GRID\Source(columns="id,idempleado.codigoempleado,tipoexpediente,idsolicitudempleo.nombrecompleto,idempleado.idcontratacion.id,idempleado.idcontratacion.puesto.idplaza.nombreplaza", groups={"grupo_empleado"})
 */
class Expediente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="expediente_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_segurovida","grupo_contratacion_aspirante","grupo_contratacion_consultar","grupo_contratacion_empleado","grupo_docdigital", "grupo_solicitud_empleado","grupo_empleado","grupo_empleado_inactivo", "grupo_acciones_empleado"}, visible=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaexpediente", type="date", nullable=false)
     */
    private $fechaexpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoexpediente", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo de expediente")
     * @Assert\Length(
     * max = "1",
     * maxMessage = "El tipo de expediente no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_segurovida","grupo_contratacion_aspirante","grupo_contratacion_consultar","grupo_contratacion_empleado", "grupo_docdigital", "grupo_solicitud_empleado","grupo_empleado","grupo_empleado_inactivo","grupo_acciones_empleado"}, visible=false)
     */
    private $tipoexpediente;

    /**
     * @ORM\OneToOne(targetEntity="Empleado", mappedBy="idexpediente")
     * @GRID\Column(field="idempleado.codigoempleado",groups={"grupo_empleado_inactivo","grupo_empleado","grupo_segurovida","grupo_contratacion_consultar","grupo_contratacion_empleado","grupo_solicitud_empleado", "grupo_acciones_empleado"} ,title="Codigo", visible=false, joinType="inner", filterable=false)
     * @GRID\Column(field="idempleado.codigoempleado",groups={"grupo_empleado_inactivo"} ,title="Codigo", visible=true, joinType="inner", filterable=true, operators={"like"},operatorsVisible=false)
     * @GRID\Column(field="idempleado.idrefrenda.idplaza.nombreplaza", groups={"grupo_segurovida","grupo_empleado","grupo_contratacion_empleado","grupo_empleado_inactivo","grupo_acciones_empleado"},type="text", title="Plaza", filterable=false, joinType="inner")
     * @GRID\Column(field="idempleado.idcontratacion.puesto.idplaza.nombreplaza", groups={"grupo_contratacion_consultar"},type="text", title="Plaza", filterable=false, joinType="inner")
     * @GRID\Column(field="idempleado.idcontratacion.id", groups={"grupo_empleado","grupo_contratacion_consultar"}, filterable=false, joinType="inner", visible=false)
     */
         //@GRID\Column(field="idempleado.idcontratacion.idlicencia.id", groups="grupo_empleado", filterable=false, visible=false)
    private $idempleado;

    /**
     * @var \Solicitudempleo
     * @ORM\OneToOne(targetEntity="Solicitudempleo", mappedBy="idexpediente", cascade={"remove"})
     * @GRID\Column(field="idsolicitudempleo.idplaza.nombreplaza", groups="grupo_contratacion_aspirante",type="text", title="Plaza solicitada", visible=false)
     * @GRID\Column(field="idsolicitudempleo.nombrecompleto", groups={"grupo_empleado","grupo_empleado_inactivo","grupo_segurovida","grupo_contratacion_aspirante","grupo_contratacion_consultar","grupo_contratacion_empleado", "grupo_docdigital", "grupo_solicitud_empleado", "grupo_acciones_empleado"} ,visible=false, joinType="inner", filterable=false)
     * @GRID\Column(field="idsolicitudempleo.fecharegistro", align="center", type="date", groups={"grupo_docdigital"}, title="Registrado",  joinType="inner", filterable=false)
     * @GRID\Column(field="idsolicitudempleo.numsolicitud", align="center", groups={"grupo_docdigital"}, title="Solicitud", joinType="inner", filterable=false )
     * @GRID\Column(field="idsolicitudempleo.id", groups={"grupo_solicitud_empleado"} ,visible=false, joinType="inner", filterable=false)
     */
    private $idsolicitudempleo;

    /**
     * @ORM\OneToMany(targetEntity="Segurovida", mappedBy="idexpediente", cascade={"remove"})
     * @GRID\Column(field="idsegurovida.id", filterable=false, groups="grupo_segurovida", visible=false)
     */
    private $idsegurovida;

    /**
     * @ORM\OneToOne(targetEntity="Pruebapsicologica", mappedBy="idexpediente", cascade={"remove"})
     */
    private $idpruebapsicologica;

    /**
     * @ORM\OneToOne(targetEntity="Hojaservicio", mappedBy="idexpediente")
     */
    private $hojaservicio;

    /**
     * @ORM\OneToMany(targetEntity="Accionpersonal", mappedBy="idexpediente", cascade={"remove"})
     */
    private $idaccion;
    
    public function __toString(){
        return $this->getTipoexpediente();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaexpediente
     *
     * @param \DateTime $fechaexpediente
     * @return Expediente
     */
    public function setFechaexpediente($fechaexpediente)
    {
        $this->fechaexpediente = $fechaexpediente;
    
        return $this;
    }

    /**
     * Get fechaexpediente
     *
     * @return \DateTime 
     */
    public function getFechaexpediente()
    {
        return $this->fechaexpediente;
    }

    /**
     * Set tipoexpediente
     *
     * @param string $tipoexpediente
     * @return Expediente
     */
    public function setTipoexpediente($tipoexpediente)
    {
        $this->tipoexpediente = $tipoexpediente;
    
        return $this;
    }

    /**
     * Get tipoexpediente
     *
     * @return string 
     */
    public function getTipoexpediente()
    {
        return $this->tipoexpediente;
    }


    public function __construct(){
    $this->Docs_expediente = new ArrayCollection();
    $this->idsegurovida = new \Doctrine\Common\Collections\ArrayCollection();
    }

/********* Documentos de Expediente *****************/
    

    /**
     * @ORM\OneToMany(targetEntity="Docexpediente", mappedBy="idexpediente", cascade={"persist", "remove"})
     */
    protected $Docs_expediente;

/********* Documentos personales *********************/

    /**
    * @ORM\OneToMany(targetEntity="Docpersonal", mappedBy="idexpediente", cascade={"persist", "remove"})
    *
    */ 
    protected $Docs_personal;
     
    public function setDocsexpediente(\Doctrine\Common\Collections\Collection $dexpedientes)
    {
        $this->Docs_expediente = $dexpedientes;

        foreach ($dexpedientes as $dexpediente) {
        $dexpediente->setIdexpediente($this); 
    }   
        }
    
    
    /**
     * Get Docs_expediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocsExpediente()
    {
        return $this->Docs_expediente;
    }


    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Expediente
     */
    public function setIdsolicitudempleo(\SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo = null)
    {
        $this->idsolicitudempleo = $idsolicitudempleo;
    
        return $this;
    }

    /**
     * Get idsolicitudempleo
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo 
     */
    public function getIdsolicitudempleo()
    {
        return $this->idsolicitudempleo;
    }

    /**
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Expediente
     */
    public function setIdempleado(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado = null)
    {
        $this->idempleado = $idempleado;
    
        return $this;
    }

    /**
     * Get idempleado
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdempleado()
    {
        return $this->idempleado;

    }
    /**
     * Add idsegurovida
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida
     * @return Expediente
     */
    public function addIdsegurovida(\SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida)
    {
        $this->idsegurovida[] = $idsegurovida;
    
        return $this;
    }

    /**
     * Remove idsegurovida
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida
     */
    public function removeIdsegurovida(\SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida)
    {
        $this->idsegurovida->removeElement($idsegurovida);
    }

    /**
     * Get idsegurovida
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdsegurovida()
    {
        return $this->idsegurovida;
    }

    /**
     * Add Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     * @return Expediente
     */
    public function addDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente[] = $docsExpediente;
    
        return $this;
    }

    /**
     * Remove Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     */
    public function removeDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente->removeElement($docsExpediente);
    }

    /**
     * Set idpruebapsicologica
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica $idpruebapsicologica
     * @return Expediente
     */
    public function setIdpruebapsicologica(\SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica $idpruebapsicologica = null)
    {
        $this->idpruebapsicologica = $idpruebapsicologica;
    
        return $this;
    }

    /**
     * Get idpruebapsicologica
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica 
     */
    public function getIdpruebapsicologica()
    {
        return $this->idpruebapsicologica;
    }

    /**
     * Add Docs_personal
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal
     * @return Expediente
     */
    public function addDocsPersonal(\SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal)
    {
        $this->Docs_personal[] = $docsPersonal;
    
        return $this;
    }

    /**
     * Remove Docs_personal
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal
     */
    public function removeDocsPersonal(\SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal)
    {
        $this->Docs_personal->removeElement($docsPersonal);
    }

    /**
     * Get Docs_personal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocsPersonal()
    {
        return $this->Docs_personal;
    }

    /**
     * Set hojaservicio
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Hojaservicio $hojaservicio
     * @return Expediente
     */
    public function setHojaservicio(\SIGESRHI\ExpedienteBundle\Entity\Hojaservicio $hojaservicio = null)
    {
        $this->hojaservicio = $hojaservicio;
    
        return $this;
    }

    /**
     * Get hojaservicio
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Hojaservicio 
     */
    public function getHojaservicio()
    {
        return $this->hojaservicio;
    }

    /**
     * Add idaccion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Accionpersonal $idaccion
     * @return Expediente
     */
    public function addIdaccion(\SIGESRHI\ExpedienteBundle\Entity\Accionpersonal $idaccion)
    {
        $this->idaccion[] = $idaccion;
    
        return $this;
    }

    /**
     * Remove idaccion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Accionpersonal $idaccion
     */
    public function removeIdaccion(\SIGESRHI\ExpedienteBundle\Entity\Accionpersonal $idaccion)
    {
        $this->idaccion->removeElement($idaccion);
    }

    /**
     * Get idaccion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdaccion()
    {
        return $this->idaccion;
    }
}