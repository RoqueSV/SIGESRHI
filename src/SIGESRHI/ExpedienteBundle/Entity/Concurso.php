<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Concurso
 *
 * @ORM\Table(name="concurso")
 * @ORM\Entity
 * @GRID\Source(columns="id,codigoconcurso,fechaapertura,fechacierre", groups={"grupo_concurso"})
 */
class Concurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="concurso_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_concurso"}, visible=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoconcurso", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el codigo de concurso")
     * @Assert\Length(
     * max = "15",
     * maxMessage = "El codigo del concurso no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_concurso"}, title="Código", align="center")
     */
    private $codigoconcurso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaapertura", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de apertura")
     * @GRID\Column(filterable=false, groups={"grupo_concurso"}, type="date", title="Fecha apertura", align="center")
     */
    private $fechaapertura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechacierre", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de cierre")
     * @GRID\Column(filterable=false, groups={"grupo_concurso"}, type="date", title="Fecha cierre", align="center")
     */
    private $fechacierre;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroacta", type="integer", nullable=true)
     */
    private $numeroacta;

    /**
     * @var integer
     *
     * @ORM\Column(name="anoacta", type="string", length=4, nullable=true)
     */
    private $anoacta;


   /**
     * @ORM\OneToMany(targetEntity="Empleadoconcurso", mappedBy="idconcurso")
     * 
     */
    private $idempleadoconcurso;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     * @GRID\Column(field="idplaza.nombreplaza", groups={"grupo_concurso"},type="text", title="Plaza", filterable=false, joinType="inner")
     */
    private $idplaza;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Centrounidad
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Centrounidad")
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
     * Set codigoconcurso
     *
     * @param string $codigoconcurso
     * @return Concurso
     */
    public function setCodigoconcurso($codigoconcurso)
    {
        $this->codigoconcurso = $codigoconcurso;
    
        return $this;
    }

    /**
     * Get codigoconcurso
     *
     * @return string 
     */
    public function getCodigoconcurso()
    {
        return $this->codigoconcurso;
    }

    /**
     * Set fechaapertura
     *
     * @param \DateTime $fechaapertura
     * @return Concurso
     */
    public function setFechaapertura($fechaapertura)
    {
        $this->fechaapertura = $fechaapertura;
    
        return $this;
    }

    /**
     * Get fechaapertura
     *
     * @return \DateTime 
     */
    public function getFechaapertura()
    {
        return $this->fechaapertura;
    }

    /**
     * Set fechacierre
     *
     * @param \DateTime $fechacierre
     * @return Concurso
     */
    public function setFechacierre($fechacierre)
    {
        $this->fechacierre = $fechacierre;
    
        return $this;
    }

    /**
     * Get fechacierre
     *
     * @return \DateTime 
     */
    public function getFechacierre()
    {
        return $this->fechacierre;
    }

    /**
     * Set numeroacta
     *
     * @param integer $numeroacta
     * @return Concurso
     */
    public function setNumeroacta($numeroacta)
    {
        $this->numeroacta = $numeroacta;
    
        return $this;
    }

    /**
     * Get numeroacta
     *
     * @return integer 
     */
    public function getNumeroacta()
    {
        return $this->numeroacta;
    }

    /**
     * Set anoacta
     *
     * @param integer $anoacta
     * @return Concurso
     */
    public function setAnoacta($anoacta)
    {
        $this->anoacta = $anoacta;
    
        return $this;
    }

    /**
     * Get anoacta
     *
     * @return integer 
     */
    public function getAnoacta()
    {
        return $this->anoacta;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Concurso
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
     * Set centro
     *
     * @param integer $centro
     * @return Concurso
     */
    public function setCentro($centro)
    {
        $this->centro = $centro;
    
        return $this;
    }

    /**
     * Get centro
     *
     * @return integer 
     */
    public function getCentro()
    {
        return $this->centro;
    }

    /**
     * Set idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     * @return Concurso
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idempleadoconcurso = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idempleadoconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso
     * @return Concurso
     */
    public function addIdempleadoconcurso(\SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso)
    {
        $this->idempleadoconcurso[] = $idempleadoconcurso;
    
        return $this;
    }

    /**
     * Remove idempleadoconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso
     */
    public function removeIdempleadoconcurso(\SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso)
    {
        $this->idempleadoconcurso->removeElement($idempleadoconcurso);
    }

    /**
     * Get idempleadoconcurso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdempleadoconcurso()
    {
        return $this->idempleadoconcurso;
    }
}