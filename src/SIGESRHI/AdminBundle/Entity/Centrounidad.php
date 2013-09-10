<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull(message="Debe ingresar un nombre de Centro")
     * @Assert\Length(
     *  max = "100"
     * )
     */
    private $nombrecentro;

    /**
     * @var string
     *
     * @ORM\Column(name="especialidad", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la Especialidad")
     * @Assert\Length( max= "100")
     */
    private $especialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccioncentro", type="string", length=100, nullable=false)
     * @Assert\Length(max= "100")
     */
    private $direccioncentro;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonocentro", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono")
     * @Assert\Length(max="8")
     */
    private $telefonocentro;

    /**
     * @var integer
     *
     * @ORM\Column(name="extensioncentro", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la extension")
     */
    private $extensioncentro;
   
     // ...
    /**
     * @ORM\OneToMany(targetEntity="Unidadorganizativa", mappedBy="idcentro")
     */
    private $idunidad;
    
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idunidad = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idunidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad
     * @return Centrounidad
     */
    public function addIdunidad(\SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad)
    {
        $this->idunidad[] = $idunidad;
    
        return $this;
    }

    /**
     * Remove idunidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad
     */
    public function removeIdunidad(\SIGESRHI\AdminBundle\Entity\Unidadorganizativa $idunidad)
    {
        $this->idunidad->removeElement($idunidad);
    }

    /**
     * Get idunidad
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdunidad()
    {
        return $this->idunidad;
    }
}