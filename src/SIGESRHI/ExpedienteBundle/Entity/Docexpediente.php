<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docexpediente
 *
 * @ORM\Table(name="docexpediente")
 * @ORM\Entity
 */
class Docexpediente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docexpediente_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocexp", type="string", length=25, nullable=false)
     */
    private $nombredocexp;

    /**
     * @var string
     *
     * @ORM\Column(name="rutadocexp", type="string", length=50, nullable=false)
     */
    private $rutadocexp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadocexp", type="date", nullable=false)
     */
    private $fechadocexp;

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
     * Set nombredocexp
     *
     * @param string $nombredocexp
     * @return Docexpediente
     */
    public function setNombredocexp($nombredocexp)
    {
        $this->nombredocexp = $nombredocexp;
    
        return $this;
    }

    /**
     * Get nombredocexp
     *
     * @return string 
     */
    public function getNombredocexp()
    {
        return $this->nombredocexp;
    }

    /**
     * Set rutadocexp
     *
     * @param string $rutadocexp
     * @return Docexpediente
     */
    public function setRutadocexp($rutadocexp)
    {
        $this->rutadocexp = $rutadocexp;
    
        return $this;
    }

    /**
     * Get rutadocexp
     *
     * @return string 
     */
    public function getRutadocexp()
    {
        return $this->rutadocexp;
    }

    /**
     * Set fechadocexp
     *
     * @param \DateTime $fechadocexp
     * @return Docexpediente
     */
    public function setFechadocexp($fechadocexp)
    {
        $this->fechadocexp = $fechadocexp;
    
        return $this;
    }

    /**
     * Get fechadocexp
     *
     * @return \DateTime 
     */
    public function getFechadocexp()
    {
        return $this->fechadocexp;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Docexpediente
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
}