<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="nombrefactor", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del factor")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del factor no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrefactor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionfactor", type="text", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion del factor")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La descripcion del factor no debe exceder los {{limit}} caracteres"
     * )
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