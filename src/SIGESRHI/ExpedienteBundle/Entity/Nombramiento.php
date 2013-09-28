<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Nombramiento
 *
 * @ORM\Table(name="nombramiento")
 * @ORM\Entity
 */
class Nombramiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="nombramiento_id_seq", allocationSize=1, initialValue=1)
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
     * @Assert\Length(
     * max = "250",
     * maxMessage = "Las observaciones del nombramiento no debe exceder los {{limit}} caracteres"
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
     * @ORM\Column(name="informacionadicional", type="string", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La informacion adicional no debe exceder los {{limit}} caracteres"
     * )
     */
    private $informacionadicional;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinnom", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $fechafinnom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaautorizacion", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de autorizacion")
     */
    private $fechaautorizacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="numoficio", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el numero de oficio")
     */
    private $numoficio;



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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
     * Set fechafinnom
     *
     * @param \DateTime $fechafinnom
     * @return Nombramiento
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
     * @return Nombramiento
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
     * @return Nombramiento
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
}