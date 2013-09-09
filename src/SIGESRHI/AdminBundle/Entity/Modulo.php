<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo")
 * @ORM\Entity
 */
class Modulo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="modulo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombremodulo", type="string", length=100, nullable=true)
     * @Assert\Length(max="100")
     */
    private $nombremodulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=true)
     * @Assert\Length(max= "15")
     */
    private $descripcion;
    
     /**
     * @ORM\OneToMany(targetEntity="Acceso", mappedBy="idmodulo")
     * @Assert\Length(max="15")
     */

    private $idacceso;
    
        public function __toString() {
  return $this->nombremodulo;
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
     * Set nombremodulo
     *
     * @param string $nombremodulo
     * @return Modulo
     */
    public function setNombremodulo($nombremodulo)
    {
        $this->nombremodulo = $nombremodulo;
    
        return $this;
    }

    /**
     * Get nombremodulo
     *
     * @return string 
     */
    public function getNombremodulo()
    {
        return $this->nombremodulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Modulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idacceso = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idacceso
     *
     * @param \SIGESRHI\AdminBundle\Entity\Acceso $idacceso
     * @return Modulo
     */
    public function addIdacceso(\SIGESRHI\AdminBundle\Entity\Acceso $idacceso)
    {
        $this->idacceso[] = $idacceso;
    
        return $this;
    }

    /**
     * Remove idacceso
     *
     * @param \SIGESRHI\AdminBundle\Entity\Acceso $idacceso
     */
    public function removeIdacceso(\SIGESRHI\AdminBundle\Entity\Acceso $idacceso)
    {
        $this->idacceso->removeElement($idacceso);
    }

    /**
     * Get idacceso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdacceso()
    {
        return $this->idacceso;
    }
}