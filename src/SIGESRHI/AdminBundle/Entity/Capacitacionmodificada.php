<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Capacitacionmodificada
 *
 * @ORM\Table(name="capacitacionmodificada")
 * @ORM\Entity
 */
class Capacitacionmodificada
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="capacitacionmodificada_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechamodificada", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $fechamodificada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horainiciomodificada", type="time", nullable=true)
     * @Assert\DateTime()
     */
    private $horainiciomodificada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horafinmodificada", type="time", nullable=true)
     * @Assert\DateTime()
     */
    private $horafinmodificada;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarmodificado", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del lugar de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lugarmodificado;

    /**
     * @var string
     *
     * @ORM\Column(name="perfilmodificado", type="string", length=150, nullable=true)
     * @Assert\Length(
     * max = "150",
     * maxMessage = "El perfil de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $perfilmodificado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cupomodificado", type="integer", nullable=true)
     */
    private $cupomodificado;

    /**
     * @var string
     *
     * @ORM\Column(name="metodologiamodificada", type="string", length=250, nullable=true)
     * @Assert\Length(
     * max = "250",
     * maxMessage = "La metodologia de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $metodologiamodificada;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadosmodificados", type="string", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "Los resultados de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $resultadosmodificados;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="plazomodificado", type="date", nullable=true)
     */
    private $plazomodificado;

    /**
     * @var string
     *
     * @ORM\Column(name="contactomodificado", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El contacto de capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $contactomodificado;

    /**
     * @var string
     *
     * @ORM\Column(name="materialmodificado", type="string", length=250, nullable=true)
     */
    private $materialmodificado;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacionmodificacion", type="string", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la Justificacion")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La justificacion de la capacitacion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $justificacionmodificacion;

    /**
     * @var \Capacitacion
     *
     * @ORM\ManyToOne(targetEntity="Capacitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcapacitacion", referencedColumnName="id")
     * })
     */
    private $idcapacitacion;



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
     * Set fechamodificada
     *
     * @param \DateTime $fechamodificada
     * @return Capacitacionmodificada
     */
    public function setFechamodificada($fechamodificada)
    {
        $this->fechamodificada = $fechamodificada;
    
        return $this;
    }

    /**
     * Get fechamodificada
     *
     * @return \DateTime 
     */
    public function getFechamodificada()
    {
        return $this->fechamodificada;
    }

    /**
     * Set horainiciomodificada
     *
     * @param \DateTime $horainiciomodificada
     * @return Capacitacionmodificada
     */
    public function setHorainiciomodificada($horainiciomodificada)
    {
        $this->horainiciomodificada = $horainiciomodificada;
    
        return $this;
    }

    /**
     * Get horainiciomodificada
     *
     * @return \DateTime 
     */
    public function getHorainiciomodificada()
    {
        return $this->horainiciomodificada;
    }

    /**
     * Set horafinmodificada
     *
     * @param \DateTime $horafinmodificada
     * @return Capacitacionmodificada
     */
    public function setHorafinmodificada($horafinmodificada)
    {
        $this->horafinmodificada = $horafinmodificada;
    
        return $this;
    }

    /**
     * Get horafinmodificada
     *
     * @return \DateTime 
     */
    public function getHorafinmodificada()
    {
        return $this->horafinmodificada;
    }

    /**
     * Set lugarmodificado
     *
     * @param string $lugarmodificado
     * @return Capacitacionmodificada
     */
    public function setLugarmodificado($lugarmodificado)
    {
        $this->lugarmodificado = $lugarmodificado;
    
        return $this;
    }

    /**
     * Get lugarmodificado
     *
     * @return string 
     */
    public function getLugarmodificado()
    {
        return $this->lugarmodificado;
    }

    /**
     * Set perfilmodificado
     *
     * @param string $perfilmodificado
     * @return Capacitacionmodificada
     */
    public function setPerfilmodificado($perfilmodificado)
    {
        $this->perfilmodificado = $perfilmodificado;
    
        return $this;
    }

    /**
     * Get perfilmodificado
     *
     * @return string 
     */
    public function getPerfilmodificado()
    {
        return $this->perfilmodificado;
    }

    /**
     * Set cupomodificado
     *
     * @param integer $cupomodificado
     * @return Capacitacionmodificada
     */
    public function setCupomodificado($cupomodificado)
    {
        $this->cupomodificado = $cupomodificado;
    
        return $this;
    }

    /**
     * Get cupomodificado
     *
     * @return integer 
     */
    public function getCupomodificado()
    {
        return $this->cupomodificado;
    }

    /**
     * Set metodologiamodificada
     *
     * @param string $metodologiamodificada
     * @return Capacitacionmodificada
     */
    public function setMetodologiamodificada($metodologiamodificada)
    {
        $this->metodologiamodificada = $metodologiamodificada;
    
        return $this;
    }

    /**
     * Get metodologiamodificada
     *
     * @return string 
     */
    public function getMetodologiamodificada()
    {
        return $this->metodologiamodificada;
    }

    /**
     * Set resultadosmodificados
     *
     * @param string $resultadosmodificados
     * @return Capacitacionmodificada
     */
    public function setResultadosmodificados($resultadosmodificados)
    {
        $this->resultadosmodificados = $resultadosmodificados;
    
        return $this;
    }

    /**
     * Get resultadosmodificados
     *
     * @return string 
     */
    public function getResultadosmodificados()
    {
        return $this->resultadosmodificados;
    }

    /**
     * Set plazomodificado
     *
     * @param \DateTime $plazomodificado
     * @return Capacitacionmodificada
     */
    public function setPlazomodificado($plazomodificado)
    {
        $this->plazomodificado = $plazomodificado;
    
        return $this;
    }

    /**
     * Get plazomodificado
     *
     * @return \DateTime 
     */
    public function getPlazomodificado()
    {
        return $this->plazomodificado;
    }

    /**
     * Set contactomodificado
     *
     * @param string $contactomodificado
     * @return Capacitacionmodificada
     */
    public function setContactomodificado($contactomodificado)
    {
        $this->contactomodificado = $contactomodificado;
    
        return $this;
    }

    /**
     * Get contactomodificado
     *
     * @return string 
     */
    public function getContactomodificado()
    {
        return $this->contactomodificado;
    }

    /**
     * Set materialmodificado
     *
     * @param string $materialmodificado
     * @return Capacitacionmodificada
     */
    public function setMaterialmodificado($materialmodificado)
    {
        $this->materialmodificado = $materialmodificado;
    
        return $this;
    }

    /**
     * Get materialmodificado
     *
     * @return string 
     */
    public function getMaterialmodificado()
    {
        return $this->materialmodificado;
    }

    /**
     * Set justificacionmodificacion
     *
     * @param string $justificacionmodificacion
     * @return Capacitacionmodificada
     */
    public function setJustificacionmodificacion($justificacionmodificacion)
    {
        $this->justificacionmodificacion = $justificacionmodificacion;
    
        return $this;
    }

    /**
     * Get justificacionmodificacion
     *
     * @return string 
     */
    public function getJustificacionmodificacion()
    {
        return $this->justificacionmodificacion;
    }

    /**
     * Set idcapacitacion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Capacitacion $idcapacitacion
     * @return Capacitacionmodificada
     */
    public function setIdcapacitacion(\SIGESRHI\AdminBundle\Entity\Capacitacion $idcapacitacion = null)
    {
        $this->idcapacitacion = $idcapacitacion;
    
        return $this;
    }

    /**
     * Get idcapacitacion
     *
     * @return \SIGESRHI\AdminBundle\Entity\Capacitacion 
     */
    public function getIdcapacitacion()
    {
        return $this->idcapacitacion;
    }
}