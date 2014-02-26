<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(name="nombrefactor", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del factor")
     * @Assert\Length(
     * max = "100",
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
     * @ORM\ManyToOne(targetEntity="Formularioevaluacion", inversedBy="Factores")
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
     * @param \SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario
     * @return Factorevaluacion
     */
    public function setIdformulario(\SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario = null)
    {
        $this->idformulario = $idformulario;
    
        return $this;
    }

    /**
     * Get idformulario
     *
     * @return \SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion 
     */
    public function getIdformulario()
    {
        return $this->idformulario;
    }



     public function __construct()
    {
        $this->Opciones = new ArrayCollection();
        $this->Incidentes = new ArrayCollection();
        $this->Respuestas = new ArrayCollection();
    }


/************************* Opciones del factor de evaluaicon ***************************/



    /**
     * @ORM\OneToMany(targetEntity="Opcion", mappedBy="idfactor", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Opciones;

    /**
     * Get Opciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOpciones()
    {
        return $this->Opciones;
    }

    public function setOpciones( $opciones)
    {
        $this->Opciones = $opciones;
        foreach ($opciones as $opcion) {
            $opcion->setIdfactor($this);
        }
    }

     /************************ INCIDENTES ****************************/

     /**
     * @ORM\OneToMany(targetEntity="Incidente", mappedBy="idfactorevaluacion", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Incidentes;

    /**
     * Get Incidentes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidentes()
    {
        return $this->Incidentes;
    }

    public function setIncidentes(\Doctrine\Common\Collections\Collection $incidentes)
    {
        $this->Incidentes = $incidentes;
        foreach ($incidentes as $incidente) {
            $incidente->setIdfactorevaluacion($this);
        }
    }


    /************************* Respuestas asociadas al factor de evaluación ***************************/

    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="idfactor", cascade={"persist"})
     * @Assert\Valid
     */
    protected $Respuestas;

    /**
     * Get Respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas()
    {
        return $this->Respuestas;
    }

    public function setRespuestas($respuestas)
    {
        $this->Respuestas = $respuestas;
        foreach ($respuestas as $respuesta) {
            $respuesta->setIdfactor($this);
        }
    }

}