<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="codigoempleado", type="string", length=5, nullable=true)
     * @Assert\Length(
     * max = "5",
     * maxMessage = "El codigo de empleado no debe exceder los {{limit}} caracteres"
     * )
     */
    private $codigoempleado;

    /**
     * @var integer
     *
     * @ORM\Column(name="partida", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la partida")
     */
    private $partida;

    /**
     * @var integer
     *
     * @ORM\Column(name="subpartida", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la subpartida")
     */
    private $subpartida;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreempleado", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del empleado")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre del empleado no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreempleado;

    /**
     * @var float
     *
     * @ORM\Column(name="salariominimo", type="float", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el salario minimo")
     */
    private $salariominimo;

    /**
     * @var float
     *
     * @ORM\Column(name="salariomaximo", type="float", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el salario maximo")
     */
    private $salariomaximo;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldoactual", type="float", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el sueldo actual")
     */
    private $sueldoactual;

    /**
     * @var string
     *
     * @ORM\Column(name="unidadpresupuestaria", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la unidad presupuestaria")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "La unidad presupuestaria no debe exceder los {{limit}} caracteres"
     * )
     */
    private $unidadpresupuestaria;

    /**
     * @var string
     *
     * @ORM\Column(name="lineapresupuestaria", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar una linea presupuestaria")
     * max = "100",
     * maxMessage = "La linea presupuestaria no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lineapresupuestaria;

    /**
     * @var string
     *
     * @ORM\Column(name="codigolp", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el codigo")
      * max = "25",
     * maxMessage = "El codigo no debe exceder los {{limit}} caracteres"
     * )
     */
    private $codigolp;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecentro", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de Centro")
     * @Assert\Length(
     *  max = "100"
     * )
     */
    private $nombrecentro;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreplaza", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de Plaza")
     * @Assert\Length(
     *  max = "100"
     * )
     */
    private $nombreplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=2, nullable=true)
     * @Assert\NotNull(message="Debe ingresar el tipo de puesto")
     * @Assert\Length(
     * max = "2",
     * maxMessage = "El tipo de puesto no debe exceder {{limit}} caracteres"
     * )
     */
    private $tipo;



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
     * Set codigoempleado
     *
     * @param string $codigoempleado
     * @return Refrenda
     */
    public function setCodigoempleado($codigoempleado)
    {
        $this->codigoempleado = $codigoempleado;
    
        return $this;
    }

    /**
     * Get codigoempleado
     *
     * @return string 
     */
    public function getCodigoempleado()
    {
        return $this->codigoempleado;
    }

    /**
     * Set nombreempleado
     *
     * @param string $nombreempleado
     * @return Refrenda
     */
    public function setNombreempleado($nombreempleado)
    {
        $this->nombreempleado = $nombreempleado;
    
        return $this;
    }

    /**
     * Get nombreempleado
     *
     * @return string 
     */
    public function getNombreempleado()
    {
        return $this->nombreempleado;
    }

    /**
     * Set nombrecentro
     *
     * @param string $nombrecentro
     * @return Refrenda
     */
    public function setNombrecentro($nombrecentro)
    {
        $this->nombrecentro = $nombrecentro;
    
        return $this;
    }

    /**
     * Get nombrecentro
     *
     * @return string 
     */
    public function getNombrecentro()
    {
        return $this->nombrecentro;
    }

    /**
     * Set nombreplaza
     *
     * @param string $nombreplaza
     * @return Refrenda
     */
    public function setNombreplaza($nombreplaza)
    {
        $this->nombreplaza = $nombreplaza;
    
        return $this;
    }

    /**
     * Get nombreplaza
     *
     * @return string 
     */
    public function getNombreplaza()
    {
        return $this->nombreplaza;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Refrenda
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}