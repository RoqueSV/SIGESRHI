<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitudcapacitacion
 *
 * @ORM\Table(name="solicitudcapacitacion")
 * @ORM\Entity
 */
class Solicitudcapacitacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="solicitudcapacitacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechasolicitud", type="date", nullable=false)
     */
    private $fechasolicitud;

    /**
     * @var integer
     *
     * @ORM\Column(name="aprobacionsolicitud", type="integer", nullable=false)
     */
    private $aprobacionsolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="motivosolicitud", type="string", length=500, nullable=true)
     */
    private $motivosolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="comentariosolicitud", type="string", length=500, nullable=true)
     */
    private $comentariosolicitud;

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
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $idusuario;



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
     * Set fechasolicitud
     *
     * @param \DateTime $fechasolicitud
     * @return Solicitudcapacitacion
     */
    public function setFechasolicitud($fechasolicitud)
    {
        $this->fechasolicitud = $fechasolicitud;
    
        return $this;
    }

    /**
     * Get fechasolicitud
     *
     * @return \DateTime 
     */
    public function getFechasolicitud()
    {
        return $this->fechasolicitud;
    }

    /**
     * Set aprobacionsolicitud
     *
     * @param integer $aprobacionsolicitud
     * @return Solicitudcapacitacion
     */
    public function setAprobacionsolicitud($aprobacionsolicitud)
    {
        $this->aprobacionsolicitud = $aprobacionsolicitud;
    
        return $this;
    }

    /**
     * Get aprobacionsolicitud
     *
     * @return integer 
     */
    public function getAprobacionsolicitud()
    {
        return $this->aprobacionsolicitud;
    }

    /**
     * Set motivosolicitud
     *
     * @param string $motivosolicitud
     * @return Solicitudcapacitacion
     */
    public function setMotivosolicitud($motivosolicitud)
    {
        $this->motivosolicitud = $motivosolicitud;
    
        return $this;
    }

    /**
     * Get motivosolicitud
     *
     * @return string 
     */
    public function getMotivosolicitud()
    {
        return $this->motivosolicitud;
    }

    /**
     * Set comentariosolicitud
     *
     * @param string $comentariosolicitud
     * @return Solicitudcapacitacion
     */
    public function setComentariosolicitud($comentariosolicitud)
    {
        $this->comentariosolicitud = $comentariosolicitud;
    
        return $this;
    }

    /**
     * Get comentariosolicitud
     *
     * @return string 
     */
    public function getComentariosolicitud()
    {
        return $this->comentariosolicitud;
    }

    /**
     * Set idcapacitacion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Capacitacion $idcapacitacion
     * @return Solicitudcapacitacion
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

    /**
     * Set idusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Empleado $idusuario
     * @return Solicitudcapacitacion
     */
    public function setIdusuario(\SIGESRHI\AdminBundle\Entity\Empleado $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \SIGESRHI\AdminBundle\Entity\Empleado 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}