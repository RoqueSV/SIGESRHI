<?php

namespace SIGESRHI\CapacitacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Capacitacion
 *
 * @ORM\Table(name="capacitacion")
 * @ORM\Entity
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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tematica", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar una tematica")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $tematica;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechacapacitacion", type="date", nullable=false)
     * @Assert\DateTime()
     */
    private $fechacapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horainiciocapacitacion", type="time", nullable=false)
     * @Assert\DateTime()
     */
    private $horainiciocapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horafincapacitacion", type="time", nullable=false)
     * @Assert\DateTime()
     */
    private $horafincapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarcapacitacion", type="string", length=50, nullable=false)
      * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del lugar de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lugarcapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="areacapacitacion", type="string", length=40, nullable=true)
     * @Assert\Length(
     * max = "40",
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
     * @ORM\Column(name="perfilcapacitacion", type="string", length=150, nullable=true)
     * @Assert\Length(
     * max = "150",
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
     * @ORM\Column(name="resultadoscapacitacion", type="string", length=500, nullable=true)
     * max = "500",
     * maxMessage = "Los resultados de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $resultadoscapacitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="plazocapacitacion", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $plazocapacitacion;

    /**
     * @var string
     *
     * @ORM\Column(name="contactocapacitacion", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
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
     * @ORM\Column(name="estadocapacitacion", type="string", nullable=false)
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
     * @var \Plancapacitacion
     *
     * @ORM\ManyToOne(targetEntity="Plancapacitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplan", referencedColumnName="id")
     * })
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
     * @param \SIGESRHI\AdminBundle\Entity\Plancapacitacion $idplan
     * @return Capacitacion
     */
    public function setIdplan(\SIGESRHI\AdminBundle\Entity\Plancapacitacion $idplan = null)
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
     * @param \SIGESRHI\AdminBundle\Entity\Capacitador $idcapacitador
     * @return Capacitacion
     */
    public function setIdcapacitador(\SIGESRHI\AdminBundle\Entity\Capacitador $idcapacitador = null)
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
}