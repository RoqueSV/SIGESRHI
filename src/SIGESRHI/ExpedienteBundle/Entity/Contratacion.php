<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contratacion
 *
 * @ORM\Table(name="contratacion")
 * @ORM\Entity
 */
class Contratacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="contratacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \SIGESRHI\AdminBundle\Entity\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Unidadorganizativa
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Unidadorganizativa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idunidad", referencedColumnName="id")
     * })
     */
    private $idunidad;

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
     * Set observaciones
     *
     * @param string $observaciones
     * @return Contratacion
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
     * @return Contratacion
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
     * @return Contratacion
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
     * @return Contratacion
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
     * @return Contratacion
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
     * @return Contratacion
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
     * @return Contratacion
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
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Contratacion
     */
    public function setIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza = null)
    {
        $this->idplaza = $idplaza;
    
        return $this;
    }

    /**
     * Get idplaza
     *
     * @return \SIGESRHI\AdminBundle\Entity\Plaza 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }

    /**
     * Set idunidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad
     * @return Contratacion
     */
    public function setIdunidad(\SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad = null)
    {
        $this->idunidad = $idunidad;
    
        return $this;
    }

    /**
     * Get idunidad
     *
     * @return \SIGESRHI\AdminBundle\Entity\Unidadorganizativa 
     */
    public function getIdunidad()
    {
        return $this->idunidad;
    }

    /**
     * Set idusuario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idusuario
     * @return Contratacion
     */
    public function setIdusuario(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}