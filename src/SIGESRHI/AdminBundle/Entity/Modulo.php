<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nombremodulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=true)
     */
    private $descripcion;

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
}