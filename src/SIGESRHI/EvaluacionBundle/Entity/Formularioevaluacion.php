<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Formularioevaluacion
 *
 * @ORM\Table(name="formularioevaluacion")
 * @ORM\Entity
 * @GRID\Source(columns="id, codigoformulario, tipoformulario", groups={"grupo_formulario"})
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
     * @GRID\Column(field="id", groups={"grupo_formulario"},visible=false, filterable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoformulario", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo de formulario")
     * @GRID\Column(field="tipoformulario", groups={"grupo_formulario"},visible=true, filterable=false, title="Título del Formulario")
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
     * @GRID\Column(field="codigoformulario", groups={"grupo_formulario"},visible=true, filterable=false, title="Código", align="center")
     */
    private $codigoformulario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrebreve", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre breve del formulario")
     */
    private $nombrebreve;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoform", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado del formulario")
     */
    private $estadoform;

       
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


    /**
     * Set nombrebreve
     *
     * @param string $nombrebreve
     * @return Formularioevaluacion
     */
    public function setNombrebreve($nombrebreve)
    {
        $this->nombrebreve = $nombrebreve;
    
        return $this;
    }

    /**
     * Get nombrebreve
     *
     * @return string 
     */
    public function getNombrebreve()
    {
        return $this->nombrebreve;
    }

      /**
     * Set estadoform
     *
     * @param string $estadoform
     * @return Formularioevaluacion
     */
    public function setEstadoform($estadoform)
    {
        $this->estadoform = $estadoform;
    
        return $this;
    }

    /**
     * Get estadoform
     *
     * @return string 
     */
    public function getEstadoform()
    {
        return $this->estadoform;
    }


  public function __construct()
    {
        $this->Factores = new ArrayCollection();
        $this->Puntajes = new ArrayCollection();
    }


/************************* Factores de evaluacion ***************************/

    /**
     * @ORM\OneToMany(targetEntity="Factorevaluacion", mappedBy="idformulario", cascade={"persist", "remove"})
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


/******************************************************************************/

   

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Puntaje", inversedBy="idformulario")
     * @ORM\JoinTable(name="formulariopuntaje",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idformulario", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idpuntaje", referencedColumnName="id")
     *   }
     * )
     */
    protected $Puntajes;

 public function setPuntajes($puntajes)
    {
        $this->Puntajes = $puntajes;
        foreach ($puntajes as $puntaje) {
            $puntaje->setIdformulario($this);
        }
    }
    /**
     * Get Puntajes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPuntajes()
    {
        return $this->Puntajes;
    }


    /**
     * Add Puntajes
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Puntaje $puntajes
     * @return Formularioevaluacion
     */
    public function addPuntajes(\SIGESRHI\EvaluacionBundle\Entity\Puntaje $puntaje)
    {
        $this->Puntajes[] = $puntaje;
    
        return $this;
    }
}