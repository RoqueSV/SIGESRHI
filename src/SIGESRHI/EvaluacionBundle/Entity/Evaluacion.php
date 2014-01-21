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
     * @Assert\Length(
     * max = "2",
     * maxMessage = "El semestre de evaluación no debe exceder los {{limit}} caracteres (I o II)"
     * )
     */
    private $semestre;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado")
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
     * @ORM\Column(name="puestoemp", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el puesto del empleado evaluado")
     */
    private $puestoemp;



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
}