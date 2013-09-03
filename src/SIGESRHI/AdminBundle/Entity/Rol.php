<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table(name="rol")
 * @ORM\Entity
 */
class Rol
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="rol_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrerol", type="string", length=20, nullable=false)
     */
    private $nombrerol;
  
        public function __toString() {
  return $this->nombrerol;
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
     * Set nombrerol
     *
     * @param string $nombrerol
     * @return Rol
     */
    public function setNombrerol($nombrerol)
    {
        $this->nombrerol = $nombrerol;
    
        return $this;
    }

    /**
     * Get nombrerol
     *
     * @return string 
     */
    public function getNombrerol()
    {
        return $this->nombrerol;
    }
}