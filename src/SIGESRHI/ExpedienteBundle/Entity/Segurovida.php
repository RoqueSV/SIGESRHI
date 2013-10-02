<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Segurovida
 *
 * @ORM\Table(name="segurovida")
 * @ORM\Entity
 */
class Segurovida
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="segurovida_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaseguro", type="date", nullable=false)
     */
    private $fechaseguro;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoseguro", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado del seguro")
     */
    private $estadoseguro;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     */
    private $idexpediente;
    /**
     * @ORM\OneToMany(targetEntity="Beneficiario", mappedBy="idsegurovida", cascade={"persist","remove"})
     */
    private $idbeneficiario;
    
    public function __toString(){
        return $this->getEstadoseguro();
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
     * Set fechaseguro
     *
     * @param \DateTime $fechaseguro
     * @return Segurovida
     */
    public function setFechaseguro($fechaseguro)
    {
        $this->fechaseguro = $fechaseguro;
    
        return $this;
    }

    /**
     * Get fechaseguro
     *
     * @return \DateTime 
     */
    public function getFechaseguro()
    {
        return $this->fechaseguro;
    }

    /**
     * Set estadoseguro
     *
     * @param string $estadoseguro
     * @return Segurovida
     */
    public function setEstadoseguro($estadoseguro)
    {
        $this->estadoseguro = $estadoseguro;
    
        return $this;
    }

    /**
     * Get estadoseguro
     *
     * @return string 
     */
    public function getEstadoseguro()
    {
        return $this->estadoseguro;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Segurovida
     */
    public function setIdexpediente(\SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idbeneficiario = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idbeneficiario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Beneficiario $idbeneficiario
     * @return Segurovida
     */
    public function addIdbeneficiario(\SIGESRHI\ExpedienteBundle\Entity\Beneficiario $idbeneficiario)
    {
        $this->idbeneficiario[] = $idbeneficiario;
    
        return $this;
    }

    /**
     * Remove idbeneficiario
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Beneficiario $idbeneficiario
     */
    public function removeIdbeneficiario(\SIGESRHI\ExpedienteBundle\Entity\Beneficiario $idbeneficiario)
    {
        $this->idbeneficiario->removeElement($idbeneficiario);
    }

    /**
     * Get idbeneficiario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdbeneficiario()
    {
        return $this->idbeneficiario;
    }

    public function setIdBeneficiario(ArrayCollection $idbeneficiario)
    {
        $this->idbeneficiario = $idbeneficiario;
    }
}