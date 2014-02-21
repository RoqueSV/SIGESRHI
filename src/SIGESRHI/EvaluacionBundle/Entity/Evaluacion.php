<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evaluacion
 *
 * @ORM\Table(name="evaluacion")
 * @ORM\Entity
 */
class Evaluacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="evaluacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharealizacion", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de realizacion")
     */
    private $fecharealizacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="anoevaluado", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el año de la evaluación")
     */
    private $anoevaluado;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", length=2, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el semestre de la evaluacion")
     */
    private $semestre;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado", inversedBy="idevaluacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     */
    private $idempleado;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idjefe", referencedColumnName="id")
     * })
     */
    private $idjefe;

    /**
     * @var integer
     *
     * @ORM\Column(name="puestoemp", type="integer", nullable=true)
     * @Assert\NotNull(message="Debe ingresar el puesto del empleado evaluado")
     */
    private $puestoemp;

     /**
     * @var integer
     *
     * @ORM\Column(name="puestojefe", type="integer", nullable=true)
     * @Assert\NotNull(message="Debe ingresar el puesto del empleado evaluador")
     */
    private $puestojefe;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=250, nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=250, nullable=true)
     */
    private $comentario;

    /**
     * @var string
     *
     * @ORM\Column(name="tiemposupervisar", type="string", length=50, nullable=true)
     */
    private $tiemposupervisar;

    /**
     * @var string
     *
     * @ORM\Column(name="cargofuncion", type="string", length=100, nullable=true)
     */
    private $cargofuncion;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechacargofuncion", type="date", nullable=true)
     */
    private $fechacargofuncion;    


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
     * Set fecharealizacion
     *
     * @param \DateTime $fecharealizacion
     * @return Evaluacion
     */
    public function setFecharealizacion($fecharealizacion)
    {
        $this->fecharealizacion = $fecharealizacion;
    
        return $this;
    }

    /**
     * Get fecharealizacion
     *
     * @return \DateTime 
     */
    public function getFecharealizacion()
    {
        return $this->fecharealizacion;
    }

    /**
     * Set anoevaluado
     *
     * @param integer $anoevaluado
     * @return Evaluacion
     */
    public function setAnoevaluado($anoevaluado)
    {
        $this->anoevaluado = $anoevaluado;
    
        return $this;
    }

    /**
     * Get anoevaluado
     *
     * @return integer 
     */
    public function getAnoevaluado()
    {
        return $this->anoevaluado;
    }

    /**
     * Set semestre
     *
     * @param string $semestre
     * @return Evaluacion
     */
    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;
    
        return $this;
    }

    /**
     * Get semestre
     *
     * @return string 
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Evaluacion
     */
    public function setIdempleado(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado = null)
    {
        $this->idempleado = $idempleado;
    
        return $this;
    }

    /**
     * Get idempleado
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    /**
     * Set idjefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe
     * @return Evaluacion
     */
    public function setIdjefe(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe = null)
    {
        $this->idjefe = $idjefe;
    
        return $this;
    }

    /**
     * Get idjefe
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdjefe()
    {
        return $this->idjefe;
    }

     /**
     * Set puestoemp
     *
     * @param integer $puestoemp
     * @return Evaluacion
     */
    public function setPuestoemp($puestoemp)
    {
        $this->puestoemp = $puestoemp;
    
        return $this;
    }

    /**
     * Get puestoemp
     *
     * @return integer 
     */
    public function getPuestoemp()
    {
        return $this->puestoemp;
    }

    /**
     * Set puestojefe
     *
     * @param integer $puestojefe
     * @return Evaluacion
     */
    public function setPuestojefe($puestojefe)
    {
        $this->puestojefe = $puestojefe;
    
        return $this;
    }

    /**
     * Get puestojefe
     *
     * @return integer 
     */
    public function getPuestojefe()
    {
        return $this->puestojefe;
    }

     /**
     * Set observacion
     *
     * @param string $observacion
     * @return Evaluacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Evaluacion
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    
        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

     /**
     * Set tiemposupervisar
     *
     * @param string $tiemposupervisar
     * @return Evaluacion
     */
    public function setTiemposupervisar($tiemposupervisar)
    {
        $this->tiemposupervisar = $tiemposupervisar;
    
        return $this;
    }

    /**
     * Get tiemposupervisar
     *
     * @return string 
     */
    public function getTiemposupervisar()
    {
        return $this->tiemposupervisar;
    }


    /************************ RESPUESTAS ****************************/
    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="idevaluacion", cascade={"persist", "remove"})
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

    public function setRespuestas(\Doctrine\Common\Collections\Collection $respuestas)
    {
        $this->Respuestas = $respuestas;
        foreach ($respuestas as $respuesta) {
            $respuesta->setIdrespuesta($this);
        }
    }

   
     /************************ INCIDENTES ****************************/
    /**
     * @ORM\OneToMany(targetEntity="Incidente", mappedBy="idevaluacion", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Incidentes;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Respuestas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Incidentes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
     public function setIncidentes(\Doctrine\Common\Collections\Collection $incidentes)
    {
        $this->Incidentes = $incidentes;
        foreach ($incidentes as $incidente) {
            $incidente->setIdevaluacion($this);
        }
    }
   

    /**
     * Get Incidentes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidentes()
    {
        return $this->Incidentes;
    }

    /**
     * Set cargofuncion
     *
     * @param string $cargofuncion
     * @return Evaluacion
     */
    public function setCargofuncion($cargofuncion)
    {
        $this->cargofuncion = $cargofuncion;
    
        return $this;
    }

    /**
     * Get cargofuncion
     *
     * @return string 
     */
    public function getCargofuncion()
    {
        return $this->cargofuncion;
    }

    /**
     * Set fechacargofuncion
     *
     * @param \DateTime $fechacargofuncion
     * @return Evaluacion
     */
    public function setFechacargofuncion($fechacargofuncion)
    {
        $this->fechacargofuncion = $fechacargofuncion;
    
        return $this;
    }

    /**
     * Get fechacargofuncion
     *
     * @return \DateTime 
     */
    public function getFechacargofuncion()
    {
        return $this->fechacargofuncion;
    }

 }