<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conocimiento
 *
 * @ORM\Table(name="conocimiento")
 * @ORM\Entity
 */
class Conocimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="conocimiento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreconocimiento", type="string", length=50, nullable=false)
     */
    private $nombreconocimiento;

      
        public function __toString() {
  return $this->nombreconocimiento;
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
     * Set nombreconocimiento
     *
     * @param string $nombreconocimiento
     * @return Conocimiento
     */
    public function setNombreconocimiento($nombreconocimiento)
    {
        $this->nombreconocimiento = $nombreconocimiento;
    
        return $this;
    }

    /**
     * Get nombreconocimiento
     *
     * @return string 
     */
    public function getNombreconocimiento()
    {
        return $this->nombreconocimiento;
    }
}