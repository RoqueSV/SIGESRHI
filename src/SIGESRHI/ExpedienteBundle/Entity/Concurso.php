<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concurso
 *
 * @ORM\Table(name="concurso")
 * @ORM\Entity
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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoconcurso", type="string", length=15, nullable=false)
     */
    private $codigoconcurso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaapertura", type="date", nullable=false)
     */
    private $fechaapertura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechacierre", type="date", nullable=false)
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
     * @ORM\Column(name="anoacta", type="integer", nullable=true)
     */
    private $anoacta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Empleado")
     * @ORM\JoinTable(name="empleadoconcurso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idconcurso", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     *   }
     * )
     */
    private $idusuario;

    /**
     * @var \SIGESRHI\AdminBundle\Entity\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add idusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Empleado $idusuario
     * @return Concurso
     */
    public function addIdusuario(\SIGESRHI\AdminBundle\Entity\Empleado $idusuario)
    {
        $this->idusuario[] = $idusuario;
    
        return $this;
    }

    /**
     * Remove idusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Empleado $idusuario
     */
    public function removeIdusuario(\SIGESRHI\AdminBundle\Entity\Empleado $idusuario)
    {
        $this->idusuario->removeElement($idusuario);
    }

    /**
     * Get idusuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
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
}