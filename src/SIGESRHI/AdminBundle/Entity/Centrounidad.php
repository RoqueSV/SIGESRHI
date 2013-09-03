<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centrounidad
 *
 * @ORM\Table(name="centrounidad")
 * @ORM\Entity
 */
class Centrounidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="centrounidad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecentro", type="string", length=100, nullable=false)
     */
    private $nombrecentro;

    /**
     * @var string
     *
     * @ORM\Column(name="especialidad", type="string", length=100, nullable=false)
     */
    private $especialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccioncentro", type="string", length=100, nullable=true)
     */
    private $direccioncentro;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonocentro", type="string", nullable=false)
     */
    private $telefonocentro;

    /**
     * @var integer
     *
     * @ORM\Column(name="extensioncentro", type="integer", nullable=false)
     */
    private $extensioncentro;
   
    public function __toString() {
  return $this->nombrecentro;
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
     * Set nombrecentro
     *
     * @param string $nombrecentro
     * @return Centrounidad
     */
    public function setNombrecentro($nombrecentro)
    {
        $this->nombrecentro = $nombrecentro;
    
        return $this;
    }

    /**
     * Get nombrecentro
     *
     * @return string 
     */
    public function getNombrecentro()
    {
        return $this->nombrecentro;
    }

    /**
     * Set especialidad
     *
     * @param string $especialidad
     * @return Centrounidad
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    
        return $this;
    }

    /**
     * Get especialidad
     *
     * @return string 
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * Set direccioncentro
     *
     * @param string $direccioncentro
     * @return Centrounidad
     */
    public function setDireccioncentro($direccioncentro)
    {
        $this->direccioncentro = $direccioncentro;
    
        return $this;
    }

    /**
     * Get direccioncentro
     *
     * @return string 
     */
    public function getDireccioncentro()
    {
        return $this->direccioncentro;
    }

    /**
     * Set telefonocentro
     *
     * @param string $telefonocentro
     * @return Centrounidad
     */
    public function setTelefonocentro($telefonocentro)
    {
        $this->telefonocentro = $telefonocentro;
    
        return $this;
    }

    /**
     * Get telefonocentro
     *
     * @return string 
     */
    public function getTelefonocentro()
    {
        return $this->telefonocentro;
    }

    /**
     * Set extensioncentro
     *
     * @param integer $extensioncentro
     * @return Centrounidad
     */
    public function setExtensioncentro($extensioncentro)
    {
        $this->extensioncentro = $extensioncentro;
    
        return $this;
    }

    /**
     * Get extensioncentro
     *
     * @return integer 
     */
    public function getExtensioncentro()
    {
        return $this->extensioncentro;
    }
}