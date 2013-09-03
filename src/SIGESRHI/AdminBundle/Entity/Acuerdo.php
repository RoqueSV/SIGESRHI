<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acuerdo
 *
 * @ORM\Table(name="acuerdo")
 * @ORM\Entity
 */
class Acuerdo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="acuerdo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idtipoaccion", type="integer", nullable=false)
     */
    private $idtipoaccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="idexpediente", type="integer", nullable=false)
     */
    private $idexpediente;

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
     * @var string
     *
     * @ORM\Column(name="numacuerdo", type="string", length=15, nullable=true)
     */
    private $numacuerdo;



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
     * Set idtipoaccion
     *
     * @param integer $idtipoaccion
     * @return Acuerdo
     */
    public function setIdtipoaccion($idtipoaccion)
    {
        $this->idtipoaccion = $idtipoaccion;
    
        return $this;
    }

    /**
     * Get idtipoaccion
     *
     * @return integer 
     */
    public function getIdtipoaccion()
    {
        return $this->idtipoaccion;
    }

    /**
     * Set idexpediente
     *
     * @param integer $idexpediente
     * @return Acuerdo
     */
    public function setIdexpediente($idexpediente)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return integer 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }

    /**
     * Set fecharegistroacccion
     *
     * @param \DateTime $fecharegistroacccion
     * @return Acuerdo
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
     * @return Acuerdo
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
     * Set numacuerdo
     *
     * @param string $numacuerdo
     * @return Acuerdo
     */
    public function setNumacuerdo($numacuerdo)
    {
        $this->numacuerdo = $numacuerdo;
    
        return $this;
    }

    /**
     * Get numacuerdo
     *
     * @return string 
     */
    public function getNumacuerdo()
    {
        return $this->numacuerdo;
    }
}