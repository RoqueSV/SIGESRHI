<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $fecharealizacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="anoevaluado", type="integer", nullable=false)
     */
    private $anoevaluado;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", nullable=false)
     */
    private $semestre;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $idusuario;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="emp_idusuario", referencedColumnName="id")
     * })
     */
    private $empusuario;



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
     * Set idusuario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idusuario
     * @return Evaluacion
     */
    public function setIdusuario(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set empusuario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $empusuario
     * @return Evaluacion
     */
    public function setEmpusuario(\SIGESRHI\ExpedienteBundle\Entity\Empleado $empusuario = null)
    {
        $this->empusuario = $empusuario;
    
        return $this;
    }

    /**
     * Get empusuario
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getEmpusuario()
    {
        return $this->empusuario;
    }
}