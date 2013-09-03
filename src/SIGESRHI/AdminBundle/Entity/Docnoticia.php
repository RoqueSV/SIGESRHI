<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docnoticia
 *
 * @ORM\Table(name="docnoticia")
 * @ORM\Entity
 */
class Docnoticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docnoticia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocnoticia", type="string", length=25, nullable=false)
     */
    private $nombredocnoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="rutadocnoticia", type="string", length=50, nullable=true)
     */
    private $rutadocnoticia;

    /**
     * @var \Noticia
     *
     * @ORM\ManyToOne(targetEntity="Noticia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idnoticia", referencedColumnName="id")
     * })
     */
    private $idnoticia;



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
     * Set nombredocnoticia
     *
     * @param string $nombredocnoticia
     * @return Docnoticia
     */
    public function setNombredocnoticia($nombredocnoticia)
    {
        $this->nombredocnoticia = $nombredocnoticia;
    
        return $this;
    }

    /**
     * Get nombredocnoticia
     *
     * @return string 
     */
    public function getNombredocnoticia()
    {
        return $this->nombredocnoticia;
    }

    /**
     * Set rutadocnoticia
     *
     * @param string $rutadocnoticia
     * @return Docnoticia
     */
    public function setRutadocnoticia($rutadocnoticia)
    {
        $this->rutadocnoticia = $rutadocnoticia;
    
        return $this;
    }

    /**
     * Get rutadocnoticia
     *
     * @return string 
     */
    public function getRutadocnoticia()
    {
        return $this->rutadocnoticia;
    }

    /**
     * Set idnoticia
     *
     * @param \SIGESRHI\AdminBundle\Entity\Noticia $idnoticia
     * @return Docnoticia
     */
    public function setIdnoticia(\SIGESRHI\AdminBundle\Entity\Noticia $idnoticia = null)
    {
        $this->idnoticia = $idnoticia;
    
        return $this;
    }

    /**
     * Get idnoticia
     *
     * @return \SIGESRHI\AdminBundle\Entity\Noticia 
     */
    public function getIdnoticia()
    {
        return $this->idnoticia;
    }
}