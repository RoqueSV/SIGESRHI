<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habilidad
 *
 * @ORM\Table(name="habilidad")
 * @ORM\Entity
 */
class Habilidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="habilidad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrehabilidad", type="string", length=75, nullable=false)
     */
    private $nombrehabilidad;

        public function __toString() {
  return $this->nombrehabilidad;
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
     * Set nombrehabilidad
     *
     * @param string $nombrehabilidad
     * @return Habilidad
     */
    public function setNombrehabilidad($nombrehabilidad)
    {
        $this->nombrehabilidad = $nombrehabilidad;
    
        return $this;
    }

    /**
     * Get nombrehabilidad
     *
     * @return string 
     */
    public function getNombrehabilidad()
    {
        return $this->nombrehabilidad;
    }
}