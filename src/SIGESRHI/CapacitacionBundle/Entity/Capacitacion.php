<?php

namespace SIGESRHI\CapacitacionBundle\Entity;
setlocale(LC_ALL, "ES_ES");
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Capacitacion
 *
 * @ORM\Table(name="capacitacion")
 * @ORM\Entity
<<<<<<< HEAD
 * @GRID\Source(columns="id,tematica,fechacapacitacion,horainiciocapacitacion,horafincapacitacion,estadocapacitacion,idplan.id", groups={"grupo_capacitacion"})
=======
 * @GRID\Source(columns="id,tematica,fechacapacitacion,horainiciocapacitacion,horafincapacitacion,idplan.idcentro.idunidad.idrefrenda.idempleado.id", groups={"grupo_capacitacion"})
>>>>>>> 1e83460cfaf0b1124ff15adc35993faee2aa2616
 */
class Capacitacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="capacitacion_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_capacitacion"}, visible=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tematica", type="string", length=75, nullable=false)
     * @Assert\NotNull(message="Debe ingresar una tematica")
     * @Assert\Length(
     * max = "75",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_capacitacion"}, visible=true, title="Temática")
     */
    private $tematica;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechacapacitacion", type="date", nullable=false)
     * @GRID\Column(filterable=true, groups={"grupo_capacitacion"}, visible=true, filter="input", type="date", inputType="datetime", format="d-m-Y", locale="es", title="Fecha", align="center", operators={"btwe","gte", "eq", "lte"}, defaultOperator="gte", operatorsVisible=true)
     */
    private $fechacapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horainiciocapacitacion", type="time", nullable=false)
     * @GRID\Column(filterable=false, groups={"grupo_capacitacion"}, visible=true, type="datetime", format="h:i a", title="Inicio", align="center")
     */
    private $horainiciocapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horafincapacitacion", type="time", nullable=false)
     * @GRID\Column(filterable=false, groups={"grupo_capacitacion"}, visible=true, type="datetime", format="h:i a", title="Fin", align="center")
     */
    private $horafincapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarcapacitacion", type="string", length=100, nullable=false)
      * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre del lugar de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lugarcapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="areacapacitacion", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del area de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $areacapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivocapacitacion", type="string", length=250, nullable=false)
      * @Assert\Length(
     * max = "250",
     * maxMessage = "El objetivo de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $objetivocapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="perfilcapacitacion", type="string", length=250, nullable=true)
     * @Assert\Length(
     * max = "250",
     * maxMessage = "El perfil de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $perfilcapacitacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="cupo", type="integer", nullable=true)
     */
    private $cupo;

    /**
     * @var string
     *
     * @ORM\Column(name="metodologia", type="string", length=250, nullable=true)
      * @Assert\Length(
     * max = "250",
     * maxMessage = "La metodología no debe exceder los {{limit}} caracteres"
     * )
     */
    private $metodologia;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoscapacitacion", type="text", length=500, nullable=true)
     * max = "500",
     * maxMessage = "Los resultados de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $resultadoscapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="plazocapacitacion", type="date", nullable=true)
     */
    private $plazocapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="contactocapacitacion", type="string", length=70, nullable=true)
     * @Assert\Length(
     * max = "70",
     * maxMessage = "Contacto de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $contactocapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="materialcapacitacion", type="string", length=250, nullable=true)
     * @Assert\Length(
     * max = "250",
     * maxMessage = "Material de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $materialcapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocapacitacion", type="string", length=1, nullable=false)
     * @GRID\Column(filterable=false, groups={"grupo_capacitacion"}, visible=false)
     */
    private $estadocapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacioncambios", type="string", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La justificacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $justificacioncambios;

    /**
     * @var string
     *
     * @ORM\Column(name="numasistentes", type="integer", nullable=true)
     */
    private $numasistentes;

    /**
     * @var string
     *
     * @ORM\Column(name="otrasconsideraciones", type="string", length=250, nullable=true)
     * @Assert\Length(
     * max = "250",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $otrasconsideraciones;

    /**
     * @var \Plancapacitacion
     *
     * @ORM\ManyToOne(targetEntity="Plancapacitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplan", referencedColumnName="id")
     * })
     * @GRID\Column(field="idplan.id", filterable=false, groups={"grupo_capacitacion"}, visible=false, joinType="inner")
     * @GRID\Column(field="idplan.idcentro.idunidad.idrefrenda.idempleado.id", visible=false, groups={"grupo_capacitacion"}, filterable=false)
     */
    private $idplan;

    /**
     * @var \Capacitador
     *
     * @ORM\ManyToOne(targetEntity="Capacitador", inversedBy="idcapacitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcapacitador", referencedColumnName="id")
     * })
     */
    private $idcapacitador;


    /**
     * @ORM\OneToMany(targetEntity="Capacitacionmodificada", mappedBy="idcapacitacion")
     */
    private $idcapacitacionmod;

    /**
     *
     * @ORM\OneToMany(targetEntity="\SIGESRHI\PortalEmpleadoBundle\Entity\SolicitudCapacitacion", mappedBy="idcapacitacion")
     */
    private $idsolicitudcapacitacion;

    public function __toString(){
        return $this->getTematica();
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
     * Set tematica
     *
     * @param string $tematica
     * @return Capacitacion
     */
    public function setTematica($tematica)
    {
        $this->tematica = $tematica;
    
        return $this;
    }

    /**
     * Get tematica
     *
     * @return string 
     */
    public function getTematica()
    {
        return $this->tematica;
    }

    /**
     * Set fechacapacitacion
     *
     * @param \DateTime $fechacapacitacion
     * @return Capacitacion
     */
    public function setFechacapacitacion($fechacapacitacion)
    {
        $this->fechacapacitacion = $fechacapacitacion;
    
        return $this;
    }

    /**
     * Get fechacapacitacion
     *
     * @return \DateTime 
     */
    public function getFechacapacitacion()
    {
        return $this->fechacapacitacion;
    }

    /**
     * Set horainiciocapacitacion
     *
     * @param \DateTime $horainiciocapacitacion
     * @return Capacitacion
     */
    public function setHorainiciocapacitacion($horainiciocapacitacion)
    {
        $this->horainiciocapacitacion = $horainiciocapacitacion;
    
        return $this;
    }

    /**
     * Get horainiciocapacitacion
     *
     * @return \DateTime 
     */
    public function getHorainiciocapacitacion()
    {
        return $this->horainiciocapacitacion;
    }

    /**
     * Set horafincapacitacion
     *
     * @param \DateTime $horafincapacitacion
     * @return Capacitacion
     */
    public function setHorafincapacitacion($horafincapacitacion)
    {
        $this->horafincapacitacion = $horafincapacitacion;
    
        return $this;
    }

    /**
     * Get horafincapacitacion
     *
     * @return \DateTime 
     */
    public function getHorafincapacitacion()
    {
        return $this->horafincapacitacion;
    }

    /**
     * Set lugarcapacitacion
     *
     * @param string $lugarcapacitacion
     * @return Capacitacion
     */
    public function setLugarcapacitacion($lugarcapacitacion)
    {
        $this->lugarcapacitacion = $lugarcapacitacion;
    
        return $this;
    }

    /**
     * Get lugarcapacitacion
     *
     * @return string 
     */
    public function getLugarcapacitacion()
    {
        return $this->lugarcapacitacion;
    }

    /**
     * Set areacapacitacion
     *
     * @param string $areacapacitacion
     * @return Capacitacion
     */
    public function setAreacapacitacion($areacapacitacion)
    {
        $this->areacapacitacion = $areacapacitacion;
    
        return $this;
    }

    /**
     * Get areacapacitacion
     *
     * @return string 
     */
    public function getAreacapacitacion()
    {
        return $this->areacapacitacion;
    }

    /**
     * Set objetivocapacitacion
     *
     * @param string $objetivocapacitacion
     * @return Capacitacion
     */
    public function setObjetivocapacitacion($objetivocapacitacion)
    {
        $this->objetivocapacitacion = $objetivocapacitacion;
    
        return $this;
    }

    /**
     * Get objetivocapacitacion
     *
     * @return string 
     */
    public function getObjetivocapacitacion()
    {
        return $this->objetivocapacitacion;
    }

    /**
     * Set perfilcapacitacion
     *
     * @param string $perfilcapacitacion
     * @return Capacitacion
     */
    public function setPerfilcapacitacion($perfilcapacitacion)
    {
        $this->perfilcapacitacion = $perfilcapacitacion;
    
        return $this;
    }

    /**
     * Get perfilcapacitacion
     *
     * @return string 
     */
    public function getPerfilcapacitacion()
    {
        return $this->perfilcapacitacion;
    }

    /**
     * Set cupo
     *
     * @param integer $cupo
     * @return Capacitacion
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;
    
        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer 
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set metodologia
     *
     * @param string $metodologia
     * @return Capacitacion
     */
    public function setMetodologia($metodologia)
    {
        $this->metodologia = $metodologia;
    
        return $this;
    }

    /**
     * Get metodologia
     *
     * @return string 
     */
    public function getMetodologia()
    {
        return $this->metodologia;
    }

    /**
     * Set resultadoscapacitacion
     *
     * @param string $resultadoscapacitacion
     * @return Capacitacion
     */
    public function setResultadoscapacitacion($resultadoscapacitacion)
    {
        $this->resultadoscapacitacion = $resultadoscapacitacion;
    
        return $this;
    }

    /**
     * Get resultadoscapacitacion
     *
     * @return string 
     */
    public function getResultadoscapacitacion()
    {
        return $this->resultadoscapacitacion;
    }

    /**
     * Set plazocapacitacion
     *
     * @param \DateTime $plazocapacitacion
     * @return Capacitacion
     */
    public function setPlazocapacitacion($plazocapacitacion)
    {
        $this->plazocapacitacion = $plazocapacitacion;
    
        return $this;
    }

    /**
     * Get plazocapacitacion
     *
     * @return \DateTime 
     */
    public function getPlazocapacitacion()
    {
        return $this->plazocapacitacion;
    }

    /**
     * Set contactocapacitacion
     *
     * @param string $contactocapacitacion
     * @return Capacitacion
     */
    public function setContactocapacitacion($contactocapacitacion)
    {
        $this->contactocapacitacion = $contactocapacitacion;
    
        return $this;
    }

    /**
     * Get contactocapacitacion
     *
     * @return string 
     */
    public function getContactocapacitacion()
    {
        return $this->contactocapacitacion;
    }

    /**
     * Set materialcapacitacion
     *
     * @param string $materialcapacitacion
     * @return Capacitacion
     */
    public function setMaterialcapacitacion($materialcapacitacion)
    {
        $this->materialcapacitacion = $materialcapacitacion;
    
        return $this;
    }

    /**
     * Get materialcapacitacion
     *
     * @return string 
     */
    public function getMaterialcapacitacion()
    {
        return $this->materialcapacitacion;
    }

    /**
     * Set estadocapacitacion
     *
     * @param string $estadocapacitacion
     * @return Capacitacion
     */
    public function setEstadocapacitacion($estadocapacitacion)
    {
        $this->estadocapacitacion = $estadocapacitacion;
    
        return $this;
    }

    /**
     * Get estadocapacitacion
     *
     * @return string 
     */
    public function getEstadocapacitacion()
    {
        return $this->estadocapacitacion;
    }

    /**
     * Set justificacioncambios
     *
     * @param string $justificacioncambios
     * @return Capacitacion
     */
    public function setJustificacioncambios($justificacioncambios)
    {
        $this->justificacioncambios = $justificacioncambios;
    
        return $this;
    }

    /**
     * Get justificacioncambios
     *
     * @return string 
     */
    public function getJustificacioncambios()
    {
        return $this->justificacioncambios;
    }

    /**
     * Set idplan
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Plancapacitacion $idplan
     * @return Capacitacion
     */
    public function setIdplan(\SIGESRHI\CapacitacionBundle\Entity\Plancapacitacion $idplan = null)
    {
        $this->idplan = $idplan;
    
        return $this;
    }

    /**
     * Get idplan
     *
     * @return \SIGESRHI\AdminBundle\Entity\Plancapacitacion 
     */
    public function getIdplan()
    {
        return $this->idplan;
    }

    /**
     * Set idcapacitador
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador
     * @return Capacitacion
     */
    public function setIdcapacitador(\SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador = null)
    {
        $this->idcapacitador = $idcapacitador;
    
        return $this;
    }

    /**
     * Get idcapacitador
     *
     * @return \SIGESRHI\AdminBundle\Entity\Capacitador 
     */
    public function getIdcapacitador()
    {
        return $this->idcapacitador;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcapacitacionmod = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idcapacitacionmod
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada $idcapacitacionmod
     * @return Capacitacion
     */
    public function addIdcapacitacionmod(\SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada $idcapacitacionmod)
    {
        $this->idcapacitacionmod[] = $idcapacitacionmod;
    
        return $this;
    }

    /**
     * Remove idcapacitacionmod
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada $idcapacitacionmod
     */
    public function removeIdcapacitacionmod(\SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada $idcapacitacionmod)
    {
        $this->idcapacitacionmod->removeElement($idcapacitacionmod);
    }

    /**
     * Get idcapacitacionmod
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcapacitacionmod()
    {
        return $this->idcapacitacionmod;
    }

    /**
<<<<<<< HEAD
     * Set numasistentes
     *
     * @param integer $numasistentes
     * @return Capacitacion
     */
    public function setNumasistentes($numasistentes)
    {
        $this->numasistentes = $numasistentes;
=======
     * Add idsolicitudcapacitacion
     *
     * @param \SIGESRHI\PortalEmpleadoBundle\Entity\SolicitudCapacitacion $idsolicitudcapacitacion
     * @return Capacitacion
     */
    public function addIdsolicitudcapacitacion(\SIGESRHI\PortalEmpleadoBundle\Entity\SolicitudCapacitacion $idsolicitudcapacitacion)
    {
        $this->idsolicitudcapacitacion[] = $idsolicitudcapacitacion;
>>>>>>> 1e83460cfaf0b1124ff15adc35993faee2aa2616
    
        return $this;
    }

    /**
<<<<<<< HEAD
     * Get numasistentes
     *
     * @return integer 
     */
    public function getNumasistentes()
    {
        return $this->numasistentes;
    }

    /**
     * Set otrasconsideraciones
     *
     * @param string $otrasconsideraciones
     * @return Capacitacion
     */
    public function setOtrasconsideraciones($otrasconsideraciones)
    {
        $this->otrasconsideraciones = $otrasconsideraciones;
    
        return $this;
    }

    /**
     * Get otrasconsideraciones
     *
     * @return string 
     */
    public function getOtrasconsideraciones()
    {
        return $this->otrasconsideraciones;
=======
     * Remove idsolicitudcapacitacion
     *
     * @param \SIGESRHI\PortalEmpleadoBundle\Entity\SolicitudCapacitacion $idsolicitudcapacitacion
     */
    public function removeIdsolicitudcapacitacion(\SIGESRHI\PortalEmpleadoBundle\Entity\SolicitudCapacitacion $idsolicitudcapacitacion)
    {
        $this->idsolicitudcapacitacion->removeElement($idsolicitudcapacitacion);
    }

    /**
     * Get idsolicitudcapacitacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdsolicitudcapacitacion()
    {
        return $this->idsolicitudcapacitacion;
>>>>>>> 1e83460cfaf0b1124ff15adc35993faee2aa2616
    }
}