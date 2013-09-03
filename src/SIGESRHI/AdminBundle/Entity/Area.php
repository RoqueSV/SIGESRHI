<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="area")
 * @ORM\Entity
 */
class Area
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="area_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrearea", type="string", length=100, nullable=false)
     */
    private $nombrearea;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionarea", type="string", length=500, nullable=true)
     */
    private $descripcionarea;
   
    public function __toString() {
  return $this->nombrearea;
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
     * Set nombrearea
     *
     * @param string $nombrearea
     * @return Area
     */
    public function setNombrearea($nombrearea)
    {
        $this->nombrearea = $nombrearea;
    
        return $this;
    }

    /**
     * Get nombrearea
     *
     * @return string 
     */
    public function getNombrearea()
    {
        return $this->nombrearea;
    }

    /**
     * Set descripcionarea
     *
     * @param string $descripcionarea
     * @return Area
     */
    public function setDescripcionarea($descripcionarea)
    {
        $this->descripcionarea = $descripcionarea;
    
        return $this;
    }

    /**
     * Get descripcionarea
     *
     * @return string 
     */
    public function getDescripcionarea()
    {
        return $this->descripcionarea;
    }
}