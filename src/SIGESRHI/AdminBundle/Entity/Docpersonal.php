<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docpersonal
 *
 * @ORM\Table(name="docpersonal")
 * @ORM\Entity
 */
class Docpersonal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docpersonal_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocpersonal", type="string", length=25, nullable=false)
     */
    private $nombredocpersonal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="entregado", type="boolean", nullable=false)
     */
    private $entregado;

    /**
     * @var integer
     *
     * @ORM\Column(name="indice", type="integer", nullable=false)
     */
    private $indice;

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
     * Set nombredocpersonal
     *
     * @param string $nombredocpersonal
     * @return Docpersonal
     */
    public function setNombredocpersonal($nombredocpersonal)
    {
        $this->nombredocpersonal = $nombredocpersonal;
    
        return $this;
    }

    /**
     * Get nombredocpersonal
     *
     * @return string 
     */
    public function getNombredocpersonal()
    {
        return $this->nombredocpersonal;
    }

    /**
     * Set entregado
     *
     * @param boolean $entregado
     * @return Docpersonal
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;
    
        return $this;
    }

    /**
     * Get entregado
     *
     * @return boolean 
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set indice
     *
     * @param integer $indice
     * @return Docpersonal
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;
    
        return $this;
    }

    /**
     * Get indice
     *
     * @return integer 
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\AdminBundle\Entity\Expediente $idexpediente
     * @return Docpersonal
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