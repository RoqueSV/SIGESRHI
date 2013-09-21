<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plancapacitacion
 *
 * @ORM\Table(name="plancapacitacion")
 * @ORM\Entity
 */
class Plancapacitacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="plancapacitacion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreplan", type="string", length=25, nullable=true)
     */
    private $nombreplan;

    /**
     * @var integer
     *
     * @ORM\Column(name="anoplan", type="integer", nullable=false)
     */
    private $anoplan;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivoplan", type="string", length=250, nullable=false)
     */
    private $objetivoplan;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionplan", type="string", length=300, nullable=true)
     */
    private $descripcionplan;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadosplan", type="string", length=500, nullable=true)
     */
    private $resultadosplan;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoplan", type="string", nullable=false)
     */
    private $tipoplan;

    /**
     * @var \Centrounidad
     *
     * @ORM\ManyToOne(targetEntity="Centrounidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcentro", referencedColumnName="id")
     * })
     */
    private $idcentro;



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
     * Set nombreplan
     *
     * @param string $nombreplan
     * @return Plancapacitacion
     */
    public function setNombreplan($nombreplan)
    {
        $this->nombreplan = $nombreplan;
    
        return $this;
    }

    /**
     * Get nombreplan
     *
     * @return string 
     */
    public function getNombreplan()
    {
        return $this->nombreplan;
    }

    /**
     * Set anoplan
     *
     * @param integer $anoplan
     * @return Plancapacitacion
     */
    public function setAnoplan($anoplan)
    {
        $this->anoplan = $anoplan;
    
        return $this;
    }

    /**
     * Get anoplan
     *
     * @return integer 
     */
    public function getAnoplan()
    {
        return $this->anoplan;
    }

    /**
     * Set objetivoplan
     *
     * @param string $objetivoplan
     * @return Plancapacitacion
     */
    public function setObjetivoplan($objetivoplan)
    {
        $this->objetivoplan = $objetivoplan;
    
        return $this;
    }

    /**
     * Get objetivoplan
     *
     * @return string 
     */
    public function getObjetivoplan()
    {
        return $this->objetivoplan;
    }

    /**
     * Set descripcionplan
     *
     * @param string $descripcionplan
     * @return Plancapacitacion
     */
    public function setDescripcionplan($descripcionplan)
    {
        $this->descripcionplan = $descripcionplan;
    
        return $this;
    }

    /**
     * Get descripcionplan
     *
     * @return string 
     */
    public function getDescripcionplan()
    {
        return $this->descripcionplan;
    }

    /**
     * Set resultadosplan
     *
     * @param string $resultadosplan
     * @return Plancapacitacion
     */
    public function setResultadosplan($resultadosplan)
    {
        $this->resultadosplan = $resultadosplan;
    
        return $this;
    }

    /**
     * Get resultadosplan
     *
     * @return string 
     */
    public function getResultadosplan()
    {
        return $this->resultadosplan;
    }

    /**
     * Set tipoplan
     *
     * @param string $tipoplan
     * @return Plancapacitacion
     */
    public function setTipoplan($tipoplan)
    {
        $this->tipoplan = $tipoplan;
    
        return $this;
    }

    /**
     * Get tipoplan
     *
     * @return string 
     */
    public function getTipoplan()
    {
        return $this->tipoplan;
    }

    /**
     * Set idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     * @return Plancapacitacion
     */
    public function setIdcentro(\SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro = null)
    {
        $this->idcentro = $idcentro;
    
        return $this;
    }

    /**
     * Get idcentro
     *
     * @return \SIGESRHI\AdminBundle\Entity\Centrounidad 
     */
    public function getIdcentro()
    {
        return $this->idcentro;
    }
}