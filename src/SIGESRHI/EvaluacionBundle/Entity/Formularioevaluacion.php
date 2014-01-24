<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Formularioevaluacion
 *
 * @ORM\Table(name="formularioevaluacion")
 * @ORM\Entity
 */
class Formularioevaluacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="formularioevaluacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoformulario", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo de formulario")
     */
    private $tipoformulario;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoformulario", type="string", length=5, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el codigo del formulario")
     * @Assert\Length(
     * max = "5",
     * maxMessage = "El codigo del formulario no debe exceder los {{limit}} caracteres"
     * )
     */
    private $codigoformulario;

       
    public function __toString() {
        return $this->tipoformulario;
    }
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
     * Set tipoformulario
     *
     * @param string $tipoformulario
     * @return Formularioevaluacion
     */
    public function setTipoformulario($tipoformulario)
    {
        $this->tipoformulario = $tipoformulario;
    
        return $this;
    }

    /**
     * Get tipoformulario
     *
     * @return string 
     */
    public function getTipoformulario()
    {
        return $this->tipoformulario;
    }

    /**
     * Set codigoformulario
     *
     * @param string $codigoformulario
     * @return Formularioevaluacion
     */
    public function setCodigoformulario($codigoformulario)
    {
        $this->codigoformulario = $codigoformulario;
    
        return $this;
    }

    /**
     * Get codigoformulario
     *
     * @return string 
     */
    public function getCodigoformulario()
    {
        return $this->codigoformulario;
    }




  public function __construct()
    {
        $this->Factores = new ArrayCollection();
    }


/************************* Factores de evaluacion ***************************/



    /**
     * @ORM\OneToMany(targetEntity="factorevaluacion", mappedBy="idformulario", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Factores;

    /**
     * Get Factores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFactores()
    {
        return $this->Factores;
    }

    public function setFactores(\Doctrine\Common\Collections\Collection $factores)
    {
        $this->Factores = $factores;
        foreach ($factores as $factor) {
            $factor->setIdformulario($this);
        }
    }



}