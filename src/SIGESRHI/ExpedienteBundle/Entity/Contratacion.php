<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(
     * max = "250",
     * maxMessage = "Las observaciones no debe exceder los {{limit}} caracteres"
     * )
     */
    private $observaciones;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldoinicial", type="float", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el sueldo inicial")
     */
    private $sueldoinicial;

    /**
     * @var integer
     *
     * @ORM\Column(name="horaslaborales", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar las horas laborales")
     */
    private $horaslaborales;

    /**
     * @var string
     *
     * @ORM\Column(name="jornadalaboral", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la jornada laboral")
     */
    private $jornadalaboral;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainiciocontratacion", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de inicio laboral")
     * @Assert\DateTime()
     */
    private $fechainiciocontratacion;

    /**
     * @var string
     *
     * @ORM\Column(name="doccontratacion", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del documento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $doccontratacion;

    /**
     * @var string
     *
     * @ORM\Column(name="informacionadicional", type="text", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La informacion adicional no debe exceder los {{limit}} caracteres"
     * )
     */
    private $informacionadicional;

     /**
     * @var string
     *
     * @ORM\Column(name="tipocontratacion", type="string", length=1, nullable=false)
     * 
     */
    private $tipocontratacion;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinnom", type="date", nullable=true)
     * 
     */
    private $fechafinnom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaautorizacion", type="date", nullable=true)
     */

    private $fechaautorizacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="numoficio", type="integer", nullable=true)
     */
    private $numoficio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafincontrato", type="date", nullable=true)
     */
    private $fechafincontrato;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza", inversedBy="idcontratacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Unidadorganizativa
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Unidadorganizativa", inversedBy="idcontratacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idunidad", referencedColumnName="id")
     * })
     */
    private $idunidad;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="idcontratacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     */
    private $idempleado;   


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
     * Set tipocontratacion
     *
     * @param string $tipocontratacion
     * @return Contratacion
     */
    public function setTipocontratacion($tipocontratacion)
    {
        $this->tipocontratacion = $tipocontratacion;
    
        return $this;
    }

    /**
     * Get tipocontratacion
     *
     * @return string 
     */
    public function getTipocontratacion()
    {
        return $this->tipocontratacion;
    }

    /**
     * Set fechafinnom
     *
     * @param \DateTime $fechafinnom
     * @return Contratacion
     */
    public function setFechafinnom($fechafinnom)
    {
        $this->fechafinnom = $fechafinnom;
    
        return $this;
    }

    /**
     * Get fechafinnom
     *
     * @return \DateTime 
     */
    public function getFechafinnom()
    {
        return $this->fechafinnom;
    }

    /**
     * Set fechaautorizacion
     *
     * @param \DateTime $fechaautorizacion
     * @return Contratacion
     */
    public function setFechaautorizacion($fechaautorizacion)
    {
        $this->fechaautorizacion = $fechaautorizacion;
    
        return $this;
    }

    /**
     * Get fechaautorizacion
     *
     * @return \DateTime 
     */
    public function getFechaautorizacion()
    {
        return $this->fechaautorizacion;
    }

    /**
     * Set numoficio
     *
     * @param integer $numoficio
     * @return Contratacion
     */
    public function setNumoficio($numoficio)
    {
        $this->numoficio = $numoficio;
    
        return $this;
    }

    /**
     * Get numoficio
     *
     * @return integer 
     */
    public function getNumoficio()
    {
        return $this->numoficio;
    }

    /**
     * Set fechafincontrato
     *
     * @param \DateTime $fechafincontrato
     * @return Contratacion
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
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Contratacion
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
}