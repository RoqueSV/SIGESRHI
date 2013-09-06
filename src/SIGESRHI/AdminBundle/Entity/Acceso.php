<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acceso
 *
 * @ORM\Table(name="acceso")
 * @ORM\Entity
 */
class Acceso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="acceso_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrepagina", type="string", length=50, nullable=true)
     */
    private $nombrepagina;

    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=200, nullable=true)
     */
    private $ruta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Rol",inversedBy="idacceso")
     * @ORM\JoinTable(name="accesorol",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idacceso", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idrol", referencedColumnName="id")
     *   }
     * )
     */
    private $idrol;

    /**
     * @var \Modulo
     *
     * @ORM\ManyToOne(targetEntity="Modulo",  inversedBy="idacceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmodulo", referencedColumnName="id")
     * })
     */
    private $idmodulo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idrol = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombrepagina
     *
     * @param string $nombrepagina
     * @return Acceso
     */
    public function setNombrepagina($nombrepagina)
    {
        $this->nombrepagina = $nombrepagina;
    
        return $this;
    }

    /**
     * Get nombrepagina
     *
     * @return string 
     */
    public function getNombrepagina()
    {
        return $this->nombrepagina;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     * @return Acceso
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    
        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Add idrol
     *
     * @param \SIGESRHI\AdminBundle\Entity\Rol $idrol
     * @return Acceso
     */
    public function addIdrol(\SIGESRHI\AdminBundle\Entity\Rol $idrol)
    {
        $this->idrol[] = $idrol;
    
        return $this;
    }

    /**
     * Remove idrol
     *
     * @param \SIGESRHI\AdminBundle\Entity\Rol $idrol
     */
    public function removeIdrol(\SIGESRHI\AdminBundle\Entity\Rol $idrol)
    {
        $this->idrol->removeElement($idrol);
    }

    /**
     * Get idrol
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set idmodulo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Modulo $idmodulo
     * @return Acceso
     */
    public function setIdmodulo(\SIGESRHI\AdminBundle\Entity\Modulo $idmodulo = null)
    {
        $this->idmodulo = $idmodulo;
    
        return $this;
    }

    /**
     * Get idmodulo
     *
     * @return \SIGESRHI\AdminBundle\Entity\Modulo 
     */
    public function getIdmodulo()
    {
        return $this->idmodulo;
    }
}