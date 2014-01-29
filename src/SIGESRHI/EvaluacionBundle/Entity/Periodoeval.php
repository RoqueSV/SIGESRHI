<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Periodoeval
 *
 * @ORM\Table(name="periodoeval")
 * @ORM\Entity
 * @GRID\Source(columns="id, anio, semestre, fechainicio, fechafin", groups={"grupo_periodo_evaluacion"})
 */
class Periodoeval
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="periodoeval_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(field="id", groups={"grupo_periodo_evaluacion"},visible=false, filterable=false)
     */
    private $id;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainicio", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de inicio para las evaluaciones.")
     * @GRID\Column(field="fechainicio", groups={"grupo_periodo_evaluacion"},visible=true, filterable=false, title="Fecha Inicio", align="center")
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafin", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de finalizacion para las evaluaciones.")
     * @GRID\Column(field="fechafin", groups={"grupo_periodo_evaluacion"},visible=true, filterable=false, title="Fecha Fin", align="center")
     */
    private $fechafin;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", length=2, nullable=false)
     * @Assert\NotNull(message="Debe Seleccionar el semestre de evaluación")
     * @GRID\Column(field="semestre", groups={"grupo_periodo_evaluacion"},visible=true, filterable=false, title="Semestre", align="center")
     */
    private $semestre;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="string", length=4, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el año de la evaluación")
     * @GRID\Column(field="anio", groups={"grupo_periodo_evaluacion"},visible=true, filterable=false, title="Año", align="center")
     */
    private $anio;


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
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     * @return Periodoeval
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    
        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime 
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     * @return Periodoeval
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;
    
        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime 
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set semestre
     *
     * @param string $semestre
     * @return Periodoeval
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
     * Set anio
     *
     * @param string $anio
     * @return Periodoeval
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    
        return $this;
    }

    /**
     * Get anio
     *
     * @return string 
     */
    public function getAnio()
    {
        return $this->anio;
    }

}