<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcion
 *
 * @ORM\Table(name="funcion")
 * @ORM\Entity
 */
class Funcion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="funcion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrefuncion", type="string", length=250, nullable=false)
     */
    private $nombrefuncion;
  
        public function __toString() {
  return $this->nombrefuncion;
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
     * Set nombrefuncion
     *
     * @param string $nombrefuncion
     * @return Funcion
     */
    public function setNombrefuncion($nombrefuncion)
    {
        $this->nombrefuncion = $nombrefuncion;
    
        return $this;
    }

    /**
     * Get nombrefuncion
     *
     * @return string 
     */
    public function getNombrefuncion()
    {
        return $this->nombrefuncion;
    }
}