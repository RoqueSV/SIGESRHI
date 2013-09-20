<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accionpersonal
 *
 * @ORM\Table(name="accionpersonal")
 * @ORM\Entity
 */
class Accionpersonal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="accionpersonal_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistroacccion", type="date", nullable=false)
     */
    private $fecharegistroacccion;

    /**
     * @var string
     *
     * @ORM\Column(name="motivoaccion", type="string", length=500, nullable=false)
     */
    private $motivoaccion;

    /**
     * @var \Tipoaccion
     *
     * @ORM\ManyToOne(targetEntity="Tipoaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtipoaccion", referencedColumnName="id")
     * })
     */
    private $idtipoaccion;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecharegistroacccion
     *
     * @param \DateTime $fecharegistroacccion
     * @return Accionpersonal
     */
    public function setFecharegistroacccion($fecharegistroacccion)
    {
        $this->fecharegistroacccion = $fecharegistroacccion;
    
        return $this;
    }

    /**
     * Get fecharegistroacccion
     *
     * @return \DateTime 
     */
    public function getFecharegistroacccion()
    {
        return $this->fecharegistroacccion;
    }

    /**
     * Set motivoaccion
     *
     * @param string $motivoaccion
     * @return Accionpersonal
     */
    public function setMotivoaccion($motivoaccion)
    {
        $this->motivoaccion = $motivoaccion;
    
        return $this;
    }

    /**
     * Get motivoaccion
     *
     * @return string 
     */
    public function getMotivoaccion()
    {
        return $this->motivoaccion;
    }

    /**
     * Set idtipoaccion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Tipoaccion $idtipoaccion
     * @return Accionpersonal
     */
    public function setIdtipoaccion(\SIGESRHI\AdminBundle\Entity\Tipoaccion $idtipoaccion = null)
    {
        $this->idtipoaccion = $idtipoaccion;
    
        return $this;
    }

    /**
     * Get idtipoaccion
     *
     * @return \SIGESRHI\AdminBundle\Entity\Tipoaccion 
     */
    public function getIdtipoaccion()
    {
        return $this->idtipoaccion;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\AdminBundle\Entity\Expediente $idexpediente
     * @return Accionpersonal
     */
    public function setIdexpediente(\SIGESRHI\AdminBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\AdminBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }
}