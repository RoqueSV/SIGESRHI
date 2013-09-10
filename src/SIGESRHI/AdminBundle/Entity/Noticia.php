<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Noticia
 *
 * @ORM\Table(name="noticia")
 * @ORM\Entity
 */
class Noticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="noticia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanoticia", type="date", nullable=false)
     */
    private $fechanoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="asuntonoticia", type="string", length=50, nullable=false)
     */
    private $asuntonoticia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainicionoticia", type="date", nullable=false)
     */
    private $fechainicionoticia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinnoticia", type="date", nullable=true)
     */
    private $fechafinnoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="contenidonoticia", type="string", length=1000, nullable=false)
     */
    private $contenidonoticia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Centrounidad")
     * @ORM\JoinTable(name="centronoticia",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idnoticia", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idcentro", referencedColumnName="id")
     *   }
     * )
     */
    private $idcentro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcentro = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechanoticia
     *
     * @param \DateTime $fechanoticia
     * @return Noticia
     */
    public function setFechanoticia($fechanoticia)
    {
        $this->fechanoticia = $fechanoticia;
    
        return $this;
    }

    /**
     * Get fechanoticia
     *
     * @return \DateTime 
     */
    public function getFechanoticia()
    {
        return $this->fechanoticia;
    }

    /**
     * Set asuntonoticia
     *
     * @param string $asuntonoticia
     * @return Noticia
     */
    public function setAsuntonoticia($asuntonoticia)
    {
        $this->asuntonoticia = $asuntonoticia;
    
        return $this;
    }

    /**
     * Get asuntonoticia
     *
     * @return string 
     */
    public function getAsuntonoticia()
    {
        return $this->asuntonoticia;
    }

    /**
     * Set fechainicionoticia
     *
     * @param \DateTime $fechainicionoticia
     * @return Noticia
     */
    public function setFechainicionoticia($fechainicionoticia)
    {
        $this->fechainicionoticia = $fechainicionoticia;
    
        return $this;
    }

    /**
     * Get fechainicionoticia
     *
     * @return \DateTime 
     */
    public function getFechainicionoticia()
    {
        return $this->fechainicionoticia;
    }

    /**
     * Set fechafinnoticia
     *
     * @param \DateTime $fechafinnoticia
     * @return Noticia
     */
    public function setFechafinnoticia($fechafinnoticia)
    {
        $this->fechafinnoticia = $fechafinnoticia;
    
        return $this;
    }

    /**
     * Get fechafinnoticia
     *
     * @return \DateTime 
     */
    public function getFechafinnoticia()
    {
        return $this->fechafinnoticia;
    }

    /**
     * Set contenidonoticia
     *
     * @param string $contenidonoticia
     * @return Noticia
     */
    public function setContenidonoticia($contenidonoticia)
    {
        $this->contenidonoticia = $contenidonoticia;
    
        return $this;
    }

    /**
     * Get contenidonoticia
     *
     * @return string 
     */
    public function getContenidonoticia()
    {
        return $this->contenidonoticia;
    }

    /**
     * Add idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     * @return Noticia
     */
    public function addIdcentro(\SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro)
    {
        $this->idcentro[] = $idcentro;
    
        return $this;
    }

    /**
     * Remove idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     */
    public function removeIdcentro(\SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro)
    {
        $this->idcentro->removeElement($idcentro);
    }

    /**
     * Get idcentro
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcentro()
    {
        return $this->idcentro;
    }
}