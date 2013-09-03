<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrato
 *
 * @ORM\Table(name="contrato")
 * @ORM\Entity
 */
class Contrato
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="contrato_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idplaza", type="integer", nullable=false)
     */
    private $idplaza;

    /**
     * @var integer
     *
     * @ORM\Column(name="idunidad", type="integer", nullable=false)
     */
    private $idunidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="idusuario", type="integer", nullable=false)
     */
    private $idusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=250, nullable=true)
     */
    private $observaciones;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldoinicial", type="float", nullable=false)
     */
    private $sueldoinicial;

    /**
     * @var integer
     *
     * @ORM\Column(name="horaslaborales", type="integer", nullable=false)
     */
    private $horaslaborales;

    /**
     * @var string
     *
     * @ORM\Column(name="jornadalaboral", type="string", nullable=false)
     */
    private $jornadalaboral;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainiciocontratacion", type="date", nullable=false)
     */
    private $fechainiciocontratacion;

    /**
     * @var string
     *
     * @ORM\Column(name="doccontratacion", type="string", length=50, nullable=true)
     */
    private $doccontratacion;

    /**
     * @var string
     *
     * @ORM\Column(name="informacionadicional", type="string", length=500, nullable=true)
     */
    private $informacionadicional;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafincontrato", type="date", nullable=false)
     */
    private $fechafincontrato;



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
     * Set idplaza
     *
     * @param integer $idplaza
     * @return Contrato
     */
    public function setIdplaza($idplaza)
    {
        $this->idplaza = $idplaza;
    
        return $this;
    }

    /**
     * Get idplaza
     *
     * @return integer 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }

    /**
     * Set idunidad
     *
     * @param integer $idunidad
     * @return Contrato
     */
    public function setIdunidad($idunidad)
    {
        $this->idunidad = $idunidad;
    
        return $this;
    }

    /**
     * Get idunidad
     *
     * @return integer 
     */
    public function getIdunidad()
    {
        return $this->idunidad;
    }

    /**
     * Set idusuario
     *
     * @param integer $idusuario
     * @return Contrato
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return integer 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Contrato
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set sueldoinicial
     *
     * @param float $sueldoinicial
     * @return Contrato
     */
    public function setSueldoinicial($sueldoinicial)
    {
        $this->sueldoinicial = $sueldoinicial;
    
        return $this;
    }

    /**
     * Get sueldoinicial
     *
     * @return float 
     */
    public function getSueldoinicial()
    {
        return $this->sueldoinicial;
    }

    /**
     * Set horaslaborales
     *
     * @param integer $horaslaborales
     * @return Contrato
     */
    public function setHoraslaborales($horaslaborales)
    {
        $this->horaslaborales = $horaslaborales;
    
        return $this;
    }

    /**
     * Get horaslaborales
     *
     * @return integer 
     */
    public function getHoraslaborales()
    {
        return $this->horaslaborales;
    }

    /**
     * Set jornadalaboral
     *
     * @param string $jornadalaboral
     * @return Contrato
     */
    public function setJornadalaboral($jornadalaboral)
    {
        $this->jornadalaboral = $jornadalaboral;
    
        return $this;
    }

    /**
     * Get jornadalaboral
     *
     * @return string 
     */
    public function getJornadalaboral()
    {
        return $this->jornadalaboral;
    }

    /**
     * Set fechainiciocontratacion
     *
     * @param \DateTime $fechainiciocontratacion
     * @return Contrato
     */
    public function setFechainiciocontratacion($fechainiciocontratacion)
    {
        $this->fechainiciocontratacion = $fechainiciocontratacion;
    
        return $this;
    }

    /**
     * Get fechainiciocontratacion
     *
     * @return \DateTime 
     */
    public function getFechainiciocontratacion()
    {
        return $this->fechainiciocontratacion;
    }

    /**
     * Set doccontratacion
     *
     * @param string $doccontratacion
     * @return Contrato
     */
    public function setDoccontratacion($doccontratacion)
    {
        $this->doccontratacion = $doccontratacion;
    
        return $this;
    }

    /**
     * Get doccontratacion
     *
     * @return string 
     */
    public function getDoccontratacion()
    {
        return $this->doccontratacion;
    }

    /**
     * Set informacionadicional
     *
     * @param string $informacionadicional
     * @return Contrato
     */
    public function setInformacionadicional($informacionadicional)
    {
        $this->informacionadicional = $informacionadicional;
    
        return $this;
    }

    /**
     * Get informacionadicional
     *
     * @return string 
     */
    public function getInformacionadicional()
    {
        return $this->informacionadicional;
    }

    /**
     * Set fechafincontrato
     *
     * @param \DateTime $fechafincontrato
     * @return Contrato
     */
    public function setFechafincontrato($fechafincontrato)
    {
        $this->fechafincontrato = $fechafincontrato;
    
        return $this;
    }

    /**
     * Get fechafincontrato
     *
     * @return \DateTime 
     */
    public function getFechafincontrato()
    {
        return $this->fechafincontrato;
    }
}