<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Manejoequipo
 *
 * @ORM\Table(name="manejoequipo")
 * @ORM\Entity
 */
class Manejoequipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="manejoequipo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombremanejo", type="string", length=75, nullable=false)
     */
    private $nombremanejo;

        public function __toString() {
  return $this->nombremanejo;
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
     * Set nombremanejo
     *
     * @param string $nombremanejo
     * @return Manejoequipo
     */
    public function setNombremanejo($nombremanejo)
    {
        $this->nombremanejo = $nombremanejo;
    
        return $this;
    }

    /**
     * Get nombremanejo
     *
     * @return string 
     */
    public function getNombremanejo()
    {
        return $this->nombremanejo;
    }
}