<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Datosempleo
 *
 * @ORM\Table(name="datosempleo")
 * @ORM\Entity
 */
class Datosempleo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="datosempleo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreempresa", type="string", length=75, nullable=false)
     */
    private $nombreempresa;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionempresa", type="string", length=150, nullable=false)
     */
    private $direccionempresa;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoempresa", type="string", nullable=false)
     */
    private $telefonoempresa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainiciolaboral", type="date", nullable=false)
     */
    private $fechainiciolaboral;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinlaboral", type="date", nullable=true)
     */
    private $fechafinlaboral;

    /**
     * @var string
     *
     * @ORM\Column(name="jefeinmediato", type="string", length=50, nullable=false)
     */
    private $jefeinmediato;

    /**
     * @var string
     *
     * @ORM\Column(name="cargodesempenado", type="string", length=50, nullable=false)
     */
    private $cargodesempenado;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldo", type="float", nullable=false)
     */
    private $sueldo;

    /**
     * @var string
     *
     * @ORM\Column(name="motivoretiro", type="string", length=200, nullable=false)
     */
    private $motivoretiro;

    /**
     * @var string
     *
     * @ORM\Column(name="tipodatoempleo", type="string", nullable=false)
     */
    private $tipodatoempleo;

    /**
     * @var \Solicitudempleo
     *
     * @ORM\ManyToOne(targetEntity="Solicitudempleo", inversedBy="Dempleos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsolicitudempleo", referencedColumnName="id")
     * })
     */

    private $idsolicitudempleo;



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
     * Set nombreempresa
     *
     * @param string $nombreempresa
     * @return Datosempleo
     */
    public function setNombreempresa($nombreempresa)
    {
        $this->nombreempresa = $nombreempresa;
    
        return $this;
    }

    /**
     * Get nombreempresa
     *
     * @return string 
     */
    public function getNombreempresa()
    {
        return $this->nombreempresa;
    }

    /**
     * Set direccionempresa
     *
     * @param string $direccionempresa
     * @return Datosempleo
     */
    public function setDireccionempresa($direccionempresa)
    {
        $this->direccionempresa = $direccionempresa;
    
        return $this;
    }

    /**
     * Get direccionempresa
     *
     * @return string 
     */
    public function getDireccionempresa()
    {
        return $this->direccionempresa;
    }

    /**
     * Set telefonoempresa
     *
     * @param string $telefonoempresa
     * @return Datosempleo
     */
    public function setTelefonoempresa($telefonoempresa)
    {
        $this->telefonoempresa = $telefonoempresa;
    
        return $this;
    }

    /**
     * Get telefonoempresa
     *
     * @return string 
     */
    public function getTelefonoempresa()
    {
        return $this->telefonoempresa;
    }

    /**
     * Set fechainiciolaboral
     *
     * @param \DateTime $fechainiciolaboral
     * @return Datosempleo
     */
    public function setFechainiciolaboral($fechainiciolaboral)
    {
        $this->fechainiciolaboral = $fechainiciolaboral;
    
        return $this;
    }

    /**
     * Get fechainiciolaboral
     *
     * @return \DateTime 
     */
    public function getFechainiciolaboral()
    {
        return $this->fechainiciolaboral;
    }

    /**
     * Set fechafinlaboral
     *
     * @param \DateTime $fechafinlaboral
     * @return Datosempleo
     */
    public function setFechafinlaboral($fechafinlaboral)
    {
        $this->fechafinlaboral = $fechafinlaboral;
    
        return $this;
    }

    /**
     * Get fechafinlaboral
     *
     * @return \DateTime 
     */
    public function getFechafinlaboral()
    {
        return $this->fechafinlaboral;
    }

    /**
     * Set jefeinmediato
     *
     * @param string $jefeinmediato
     * @return Datosempleo
     */
    public function setJefeinmediato($jefeinmediato)
    {
        $this->jefeinmediato = $jefeinmediato;
    
        return $this;
    }

    /**
     * Get jefeinmediato
     *
     * @return string 
     */
    public function getJefeinmediato()
    {
        return $this->jefeinmediato;
    }

    /**
     * Set cargodesempenado
     *
     * @param string $cargodesempenado
     * @return Datosempleo
     */
    public function setCargodesempenado($cargodesempenado)
    {
        $this->cargodesempenado = $cargodesempenado;
    
        return $this;
    }

    /**
     * Get cargodesempenado
     *
     * @return string 
     */
    public function getCargodesempenado()
    {
        return $this->cargodesempenado;
    }

    /**
     * Set sueldo
     *
     * @param float $sueldo
     * @return Datosempleo
     */
    public function setSueldo($sueldo)
    {
        $this->sueldo = $sueldo;
    
        return $this;
    }

    /**
     * Get sueldo
     *
     * @return float 
     */
    public function getSueldo()
    {
        return $this->sueldo;
    }

    /**
     * Set motivoretiro
     *
     * @param string $motivoretiro
     * @return Datosempleo
     */
    public function setMotivoretiro($motivoretiro)
    {
        $this->motivoretiro = $motivoretiro;
    
        return $this;
    }

    /**
     * Get motivoretiro
     *
     * @return string 
     */
    public function getMotivoretiro()
    {
        return $this->motivoretiro;
    }

    /**
     * Set tipodatoempleo
     *
     * @param string $tipodatoempleo
     * @return Datosempleo
     */
    public function setTipodatoempleo($tipodatoempleo)
    {
        $this->tipodatoempleo = $tipodatoempleo;
    
        return $this;
    }

    /**
     * Get tipodatoempleo
     *
     * @return string 
     */
    public function getTipodatoempleo()
    {
        return $this->tipodatoempleo;
    }

    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Datosempleo
     */
    public function setIdsolicitudempleo(\SIGESRHI\AdminBundle\Entity\Solicitudempleo $idsolicitudempleo = null)
    {
        $this->idsolicitudempleo = $idsolicitudempleo;
    
        return $this;
    }

    /**
     * Get idsolicitudempleo
     *
     * @return \SIGESRHI\AdminBundle\Entity\Solicitudempleo 
     */
    public function getIdsolicitudempleo()
    {
        return $this->idsolicitudempleo;
    }
}