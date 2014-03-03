<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Opcion
 *
 * @ORM\Table(name="opcion")
 * @ORM\Entity
 */
class Opcion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="opcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreopcion", type="string", length=2, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la opcion")
     * @Assert\Length(
     * max = "2",
     * maxMessage = "El nombre de la opcion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreopcion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionopcion", type="string", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion de la opcion")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La descripcion de la opcion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $descripcionopcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="valoropcion", type="integer", nullable=false)
     */
    private $valoropcion;

    /**
     * @var \Factorevaluacion
     *
     * @ORM\ManyToOne(targetEntity="Factorevaluacion", inversedBy="Opciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfactor", referencedColumnName="id")
     * })
     */
    private $idfactor;



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
     * Set nombreopcion
     *
     * @param string $nombreopcion
     * @return Opcion
     */
    public function setNombreopcion($nombreopcion)
    {
        $this->nombreopcion = $nombreopcion;
    
        return $this;
    }

    /**
     * Get nombreopcion
     *
     * @return string 
     */
    public function getNombreopcion()
    {
        return $this->nombreopcion;
    }

    /**
     * Set descripcionopcion
     *
     * @param string $descripcionopcion
     * @return Opcion
     */
    public function setDescripcionopcion($descripcionopcion)
    {
        $this->descripcionopcion = $descripcionopcion;
    
        return $this;
    }

    /**
     * Get descripcionopcion
     *
     * @return string 
     */
    public function getDescripcionopcion()
    {
        return $this->descripcionopcion;
    }

    /**
     * Set valoropcion
     *
     * @param integer $valoropcion
     * @return Opcion
     */
    public function setValoropcion($valoropcion)
    {
        $this->valoropcion = $valoropcion;
    
        return $this;
    }

    /**
     * Get valoropcion
     *
     * @return integer 
     */
    public function getValoropcion()
    {
        return $this->valoropcion;
    }

    /**
     * Set idfactor
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactor
     * @return Opcion
     */
    public function setIdfactor(\SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion $idfactor = null)
    {
        $this->idfactor = $idfactor;
    
        return $this;
    }

    /**
     * Get idfactor
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Factorevaluacion 
     */
    public function getIdfactor()
    {
        return $this->idfactor;
    }


    //constructor del array()
     public function __construct()
    {
        $this->Respuestas = new ArrayCollection();
    }

    /************************* Respuestas asociadas a la opcion del factor de evaluación ***************************/

    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="idopcion", cascade={"persist"})
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