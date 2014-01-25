<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 *
 * @ORM\Table(name="respuesta")
 * @ORM\Entity
 */
class Respuesta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="respuesta_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Factorevaluacion
     *
     * @ORM\ManyToOne(targetEntity="Factorevaluacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfactor", referencedColumnName="id")
     * })
     */
    private $idfactor;

    /**
     * @var \Opcion
     *
     * @ORM\ManyToOne(targetEntity="Opcion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idopcion", referencedColumnName="id")
     * })
     */
    private $idopcion;

    /**
     * @var \Evaluacion
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion", inversedBy="Respuestas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevaluacion", referencedColumnName="id")
     * })
     */
    private $idevaluacion;



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
     * Set idfactor
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactor
     * @return Respuesta
     */
    public function setIdfactor(\SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactor = null)
    {
        $this->idfactor = $idfactor;
    
        return $this;
    }

    /**
     * Get idfactor
     *
     * @return \SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion 
     */
    public function getIdfactor()
    {
        return $this->idfactor;
    }

    /**
     * Set idopcion
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Opcion $idopcion
     * @return Respuesta
     */
    public function setIdopcion(\SIGESRHI\EvaluacionBundle\Entity\Opcion $idopcion = null)
    {
        $this->idopcion = $idopcion;
    
        return $this;
    }

    /**
     * Get idopcion
     *
     * @return \SIGESRHI\EvaluacionBundle\Entity\Opcion 
     */
    public function getIdopcion()
    {
        return $this->idopcion;
    }

    /**
     * Set idevaluacion
     *
     * @param \SIGESRHI\EvluacionBundle\Entity\Evaluacion $idevaluacion
     * @return Respuesta
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