<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factorevaluacion
 *
 * @ORM\Table(name="factorevaluacion")
 * @ORM\Entity
 */
class Factorevaluacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="factorevaluacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrefactor", type="string", length=25, nullable=false)
     */
    private $nombrefactor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionfactor", type="string", length=250, nullable=false)
     */
    private $descripcionfactor;

    /**
     * @var \Formularioevaluacion
     *
     * @ORM\ManyToOne(targetEntity="Formularioevaluacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idformulario", referencedColumnName="id")
     * })
     */
    private $idformulario;



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
     * Set nombrefactor
     *
     * @param string $nombrefactor
     * @return Factorevaluacion
     */
    public function setNombrefactor($nombrefactor)
    {
        $this->nombrefactor = $nombrefactor;
    
        return $this;
    }

    /**
     * Get nombrefactor
     *
     * @return string 
     */
    public function getNombrefactor()
    {
        return $this->nombrefactor;
    }

    /**
     * Set descripcionfactor
     *
     * @param string $descripcionfactor
     * @return Factorevaluacion
     */
    public function setDescripcionfactor($descripcionfactor)
    {
        $this->descripcionfactor = $descripcionfactor;
    
        return $this;
    }

    /**
     * Get descripcionfactor
     *
     * @return string 
     */
    public function getDescripcionfactor()
    {
        return $this->descripcionfactor;
    }

    /**
     * Set idformulario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario
     * @return Factorevaluacion
     */
    public function setIdformulario(\SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario = null)
    {
        $this->idformulario = $idformulario;
    
        return $this;
    }

    /**
     * Get idformulario
     *
     * @return \SIGESRHI\AdminBundle\Entity\Formularioevaluacion 
     */
    public function getIdformulario()
    {
        return $this->idformulario;
    }
}