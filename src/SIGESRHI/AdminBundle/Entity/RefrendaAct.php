<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Refrenda
 *
 * @ORM\Table(name="refrendaact")
 * @ORM\Entity
 */
class RefrendaAct
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
     * @Assert\NotNull(message="Debe ingresar el codigo del empleado")
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
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado", inversedBy="idrefrenda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     */
    private $idempleado;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza", inversedBy="idrefrenda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

     /**
     * @var string
     *
     * @ORM\Column(name="nombreplaza", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la plaza")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre de la plaza no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreplaza;

    /**
     * @ORM\OneToMany(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Contratacion", mappedBy="puesto")
     */
    private $puestoempleado;

    /**
     * @ORM\OneToMany(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Contratacion", mappedBy="puestojefe")
     */
    private $idpuestojefe;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Unidadorganizativa
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Unidadorganizativa", inversedBy="idrefrenda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idunidad", referencedColumnName="id")
     * })
     */
    private $idunidad;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=2, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo de puesto")
     * @Assert\Length(
     * max = "2",
     * maxMessage = "El tipo de puesto no debe exceder {{limit}} caracteres"
     * )
     */
   // private $tipo;

    public function __toString() {
        return $this->getNombreplaza();
       }
    
    public function getPuesto(){
        return "Partida ".$this->getPartida().", Subpartida ".$this->getSubpartida()."- ".$this->getNombreplaza();
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
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Refrenda
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
     * Set codigoempleado
     *
     * @param string $codigoempleado
     * @return RefrendaAct
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
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return RefrendaAct
     */
    public function setIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza = null)
    {
        $this->idplaza = $idplaza;
    
        return $this;
    }

    /**
     * Get idplaza
     *
     * @return \SIGESRHI\AdminBundle\Entity\Plaza 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }

    /**
     * Set puestoempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado
     * @return RefrendaAct
     */
    public function setPuestoempleado(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado = null)
    {
        $this->puestoempleado = $puestoempleado;
    
        return $this;
    }

    /**
     * Get puestoempleado
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Contratacion 
     */
    public function getPuestoempleado()
    {
        return $this->puestoempleado;
    }

    /**
     * Set idpuestojefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe
     * @return RefrendaAct
     */
    public function setIdpuestojefe(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe = null)
    {
        $this->idpuestojefe = $idpuestojefe;
    
        return $this;
    }

    /**
     * Get idpuestojefe
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Contratacion 
     */
    public function getIdpuestojefe()
    {
        return $this->idpuestojefe;
    }

    /**
     * Set idunidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad
     * @return RefrendaAct
     */
    public function setIdunidad(\SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad = null)
    {
        $this->idunidad = $idunidad;
    
        return $this;
    }

    /**
     * Get idunidad
     *
     * @return \SIGESRHI\AdminBundle\Entity\Unidadorganizativa 
     */
    public function getIdunidad()
    {
        return $this->idunidad;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idpuestojefe = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set nombreplaza
     *
     * @param string $nombreplaza
     * @return RefrendaAct
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
     * Add idpuestojefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe
     * @return RefrendaAct
     */
    public function addIdpuestojefe(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe)
    {
        $this->idpuestojefe[] = $idpuestojefe;
    
        return $this;
    }

    /**
     * Remove idpuestojefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe
     */
    public function removeIdpuestojefe(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idpuestojefe)
    {
        $this->idpuestojefe->removeElement($idpuestojefe);
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return RefrendaAct
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

    /**
     * Add puestoempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado
     * @return RefrendaAct
     */
    public function addPuestoempleado(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado)
    {
        $this->puestoempleado[] = $puestoempleado;
    
        return $this;
    }

    /**
     * Remove puestoempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado
     */
    public function removePuestoempleado(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $puestoempleado)
    {
        $this->puestoempleado->removeElement($puestoempleado);
    }
}