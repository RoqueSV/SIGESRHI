<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refrenda
 *
 * @ORM\Table(name="refrenda")
 * @ORM\Entity
 */
class Refrenda
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="refrenda_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="partida", type="integer", nullable=false)
     */
    private $partida;

    /**
     * @var integer
     *
     * @ORM\Column(name="subpartida", type="integer", nullable=false)
     */
    private $subpartida;

    /**
     * @var float
     *
     * @ORM\Column(name="salariominimo", type="float", nullable=false)
     */
    private $salariominimo;

    /**
     * @var float
     *
     * @ORM\Column(name="salariomaximo", type="float", nullable=false)
     */
    private $salariomaximo;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldoactual", type="float", nullable=false)
     */
    private $sueldoactual;

    /**
     * @var string
     *
     * @ORM\Column(name="unidadpresupuestaria", type="string", length=100, nullable=false)
     */
    private $unidadpresupuestaria;

    /**
     * @var string
     *
     * @ORM\Column(name="lineapresupuestaria", type="string", length=100, nullable=false)
     */
    private $lineapresupuestaria;

    /**
     * @var string
     *
     * @ORM\Column(name="codigolp", type="string", length=25, nullable=false)
     */
    private $codigolp;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set partida
     *
     * @param integer $partida
     * @return Refrenda
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;
    
        return $this;
    }

    /**
     * Get partida
     *
     * @return integer 
     */
    public function getPartida()
    {
        return $this->partida;
    }

    /**
     * Set subpartida
     *
     * @param integer $subpartida
     * @return Refrenda
     */
    public function setSubpartida($subpartida)
    {
        $this->subpartida = $subpartida;
    
        return $this;
    }

    /**
     * Get subpartida
     *
     * @return integer 
     */
    public function getSubpartida()
    {
        return $this->subpartida;
    }

    /**
     * Set salariominimo
     *
     * @param float $salariominimo
     * @return Refrenda
     */
    public function setSalariominimo($salariominimo)
    {
        $this->salariominimo = $salariominimo;
    
        return $this;
    }

    /**
     * Get salariominimo
     *
     * @return float 
     */
    public function getSalariominimo()
    {
        return $this->salariominimo;
    }

    /**
     * Set salariomaximo
     *
     * @param float $salariomaximo
     * @return Refrenda
     */
    public function setSalariomaximo($salariomaximo)
    {
        $this->salariomaximo = $salariomaximo;
    
        return $this;
    }

    /**
     * Get salariomaximo
     *
     * @return float 
     */
    public function getSalariomaximo()
    {
        return $this->salariomaximo;
    }

    /**
     * Set sueldoactual
     *
     * @param float $sueldoactual
     * @return Refrenda
     */
    public function setSueldoactual($sueldoactual)
    {
        $this->sueldoactual = $sueldoactual;
    
        return $this;
    }

    /**
     * Get sueldoactual
     *
     * @return float 
     */
    public function getSueldoactual()
    {
        return $this->sueldoactual;
    }

    /**
     * Set unidadpresupuestaria
     *
     * @param string $unidadpresupuestaria
     * @return Refrenda
     */
    public function setUnidadpresupuestaria($unidadpresupuestaria)
    {
        $this->unidadpresupuestaria = $unidadpresupuestaria;
    
        return $this;
    }

    /**
     * Get unidadpresupuestaria
     *
     * @return string 
     */
    public function getUnidadpresupuestaria()
    {
        return $this->unidadpresupuestaria;
    }

    /**
     * Set lineapresupuestaria
     *
     * @param string $lineapresupuestaria
     * @return Refrenda
     */
    public function setLineapresupuestaria($lineapresupuestaria)
    {
        $this->lineapresupuestaria = $lineapresupuestaria;
    
        return $this;
    }

    /**
     * Get lineapresupuestaria
     *
     * @return string 
     */
    public function getLineapresupuestaria()
    {
        return $this->lineapresupuestaria;
    }

    /**
     * Set codigolp
     *
     * @param string $codigolp
     * @return Refrenda
     */
    public function setCodigolp($codigolp)
    {
        $this->codigolp = $codigolp;
    
        return $this;
    }

    /**
     * Get codigolp
     *
     * @return string 
     */
    public function getCodigolp()
    {
        return $this->codigolp;
    }

    /**
     * Set idusuario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idusuario
     * @return Refrenda
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
}