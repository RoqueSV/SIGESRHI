<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Licencia
 *
 * @ORM\Table(name="licencia")
 * @ORM\Entity
 */
class Licencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="licencia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="string", length=12, nullable=false)
     * @Assert\Length(
     * max = "12",
     * maxMessage = "El concepto de la licencia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $concepto;

    /**
     * @var integer
     *
     * @ORM\Column(name="duraciondias", type="integer", nullable=true)
     */
    private $duraciondias;

    /**
     * @var integer
     *
     * @ORM\Column(name="duracionhoras", type="integer", nullable=true)
     */
    private $duracionhoras;

    /**
     * @var integer
     *
     * @ORM\Column(name="duracionminutos", type="integer", nullable=true)
     */
    private $duracionminutos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="congoce", type="boolean", nullable=false)
     * @Assert\NotNull(message="Debe especificar si la licencia es con goce o no")
     */
    private $congoce;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainiciolic", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $fechainiciolic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinlic", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $fechafinlic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horainiciolic", type="time", nullable=true)
     * @Assert\DateTime()
     */
    private $horainiciolic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horafinlic", type="time", nullable=true)
     * @Assert\DateTime()
     */
    private $horafinlic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechapermiso", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de licencia")
     * @Assert\DateTime()
     */
    private $fechapermiso;

    /**
     * @var \Contratacion
     *
     * @ORM\ManyToOne(targetEntity="Contratacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcontratacion", referencedColumnName="id")
     * })
     */
    private $idcontratacion;



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
     * Set concepto
     *
     * @param string $concepto
     * @return Licencia
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    
        return $this;
    }

    /**
     * Get concepto
     *
     * @return string 
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set duraciondias
     *
     * @param integer $duraciondias
     * @return Licencia
     */
    public function setDuraciondias($duraciondias)
    {
        $this->duraciondias = $duraciondias;
    
        return $this;
    }

    /**
     * Get duraciondias
     *
     * @return integer 
     */
    public function getDuraciondias()
    {
        return $this->duraciondias;
    }

    /**
     * Set duracionhoras
     *
     * @param integer $duracionhoras
     * @return Licencia
     */
    public function setDuracionhoras($duracionhoras)
    {
        $this->duracionhoras = $duracionhoras;
    
        return $this;
    }

    /**
     * Get duracionhoras
     *
     * @return integer 
     */
    public function getDuracionhoras()
    {
        return $this->duracionhoras;
    }

    /**
     * Set duracionminutos
     *
     * @param integer $duracionminutos
     * @return Licencia
     */
    public function setDuracionminutos($duracionminutos)
    {
        $this->duracionminutos = $duracionminutos;
    
        return $this;
    }

    /**
     * Get duracionminutos
     *
     * @return integer 
     */
    public function getDuracionminutos()
    {
        return $this->duracionminutos;
    }

    /**
     * Set congoce
     *
     * @param boolean $congoce
     * @return Licencia
     */
    public function setCongoce($congoce)
    {
        $this->congoce = $congoce;
    
        return $this;
    }

    /**
     * Get congoce
     *
     * @return boolean 
     */
    public function getCongoce()
    {
        return $this->congoce;
    }

    /**
     * Set fechainiciolic
     *
     * @param \DateTime $fechainiciolic
     * @return Licencia
     */
    public function setFechainiciolic($fechainiciolic)
    {
        $this->fechainiciolic = $fechainiciolic;
    
        return $this;
    }

    /**
     * Get fechainiciolic
     *
     * @return \DateTime 
     */
    public function getFechainiciolic()
    {
        return $this->fechainiciolic;
    }

    /**
     * Set fechafinlic
     *
     * @param \DateTime $fechafinlic
     * @return Licencia
     */
    public function setFechafinlic($fechafinlic)
    {
        $this->fechafinlic = $fechafinlic;
    
        return $this;
    }

    /**
     * Get fechafinlic
     *
     * @return \DateTime 
     */
    public function getFechafinlic()
    {
        return $this->fechafinlic;
    }

    /**
     * Set horainiciolic
     *
     * @param \DateTime $horainiciolic
     * @return Licencia
     */
    public function setHorainiciolic($horainiciolic)
    {
        $this->horainiciolic = $horainiciolic;
    
        return $this;
    }

    /**
     * Get horainiciolic
     *
     * @return \DateTime 
     */
    public function getHorainiciolic()
    {
        return $this->horainiciolic;
    }

    /**
     * Set horafinlic
     *
     * @param \DateTime $horafinlic
     * @return Licencia
     */
    public function setHorafinlic($horafinlic)
    {
        $this->horafinlic = $horafinlic;
    
        return $this;
    }

    /**
     * Get horafinlic
     *
     * @return \DateTime 
     */
    public function getHorafinlic()
    {
        return $this->horafinlic;
    }

    /**
     * Set fechapermiso
     *
     * @param \DateTime $fechapermiso
     * @return Licencia
     */
    public function setFechapermiso($fechapermiso)
    {
        $this->fechapermiso = $fechapermiso;
    
        return $this;
    }

    /**
     * Get fechapermiso
     *
     * @return \DateTime 
     */
    public function getFechapermiso()
    {
        return $this->fechapermiso;
    }



    /**
     * Set idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     * @return Licencia
     */
    public function setIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion = null)
    {
        $this->idcontratacion = $idcontratacion;
    
        return $this;
    }

    /**
     * Get idcontratacion
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Contratacion 
     */
    public function getIdcontratacion()
    {
        return $this->idcontratacion;
    }
}