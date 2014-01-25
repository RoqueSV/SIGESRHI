<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Incidente
 *
 * @ORM\Table(name="incidente")
 * @ORM\Entity
 */
class Incidente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="incidente_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Factorevaluacion
     *
     * @ORM\ManyToOne(targetEntity="Factorevaluacion", inversedBy="Incidentes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfactorevaluacion", referencedColumnName="id")
     * })
     */
    private $idfactorevaluacion;


    /**
     * @var \Evaluacion
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion", inversedBy="Incidentes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevaluacion", referencedColumnName="id")
     * })
     */
    private $idevaluacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaincidente", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de en que ocurrio el incidente")
     */
    private $fechaincidente;

     /**
     * @var string
     *
     * @ORM\Column(name="tipoincidente", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe seleccionar el tipo de incidente ocurrido")
     */
    private $tipoincidente;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionincidente", type="string", length=250, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion del evento.")
     */
    private $descripcionincidente;



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
     * Set fechaincidente
     *
     * @param \DateTime $fechaincidente
     * @return Incidente
     */
    public function setFechaincidente($fechaincidente)
    {
        $this->fechaincidente = $fechaincidente;
    
        return $this;
    }

    /**
     * Get fechaincidente
     *
     * @return \DateTime 
     */
    public function getFechaincidente()
    {
        return $this->fechaincidente;
    }

    /**
     * Set tipoincidente
     *
     * @param string $tipoincidente
     * @return Incidente
     */
    public function setTipoincidente($tipoincidente)
    {
        $this->tipoincidente = $tipoincidente;
    
        return $this;
    }

    /**
     * Get tipoincidente
     *
     * @return string 
     */
    public function getTipoincidente()
    {
        return $this->tipoincidente;
    }

    /**
     * Set descripcionincidente
     *
     * @param string $descripcionincidente
     * @return Incidente
     */
    public function setDescripcionincidente($descripcionincidente)
    {
        $this->descripcionincidente = $descripcionincidente;
    
        return $this;
    }

    /**
     * Get descripcionincidente
     *
     * @return string 
     */
    public function getDescripcionincidente()
    {
        return $this->descripcionincidente;
    }

    /**
     * Set idfactorevaluacion
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactorevaluacion
     * @return Incidente
     */
    public function setIdfactorevaluacion(\SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactorevaluacion = null)
    {
        $this->idfactorevaluacion = $idfactorevaluacion;
    
        return $this;
    }

    /**
     * Get idfactorevaluacion
     *
     * @return \SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion 
     */
    public function getIdfactorevaluacion()
    {
        return $this->idfactorevaluacion;
    }

    /**
     * Set idevaluacion
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion
     * @return Incidente
     */
    public function setIdevaluacion(\SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion = null)
    {
        $this->idevaluacion = $idevaluacion;
    
        return $this;
    }

    /**
     * Get idevaluacion
     *
     * @return \SIGESRHI\EvaluacionBundle\Entity\Evaluacion 
     */
    public function getIdevaluacion()
    {
        return $this->idevaluacion;
    }
}