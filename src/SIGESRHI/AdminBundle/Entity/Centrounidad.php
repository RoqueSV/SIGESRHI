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
     * @ORM\Column(name="especialidad", type="text", length=255, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la Especialidad")
     */
    private $especialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccioncentro", type="string", length=200, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la direccion")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "La direccion del centro no debe exceder los {{limit}} caracteres"
     * )
     */
    private $direccioncentro;

    /**
     * @var string
     *
     * @ORM\Column(name="faxcentro", type="string", length=8, nullable=true)
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El fax no debe exceder los {{limit}} caracteres"
     * )
     * 
     */
    private $faxcentro;

    /**
     * @var string
     *
     * @ORM\Column(name="pbxcentro", type="string",length=8, nullable=true)
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El pbx no debe exceder los {{limit}} caracteres"
     * )
     * 
     */
    private $pbxcentro;

    /**
     * @var string
     *
     * @ORM\Column(name="emailcentro", type="string", length=50, nullable=true)
     * @Assert\Email(
     * message = "El mail '{{ value }}' ingresado no tiene el formato correcto.")
     */
    private $emailcentro;
    // Uno a muchos con tabla union
     /**
     * @ORM\ManyToMany(targetEntity="Telefono")
     * @ORM\JoinTable(name="telefonocentro",
     *      joinColumns={@ORM\JoinColumn(name="idcentro", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idtelefono", referencedColumnName="id", unique=true)}
     *      )
     */
    private $idtelefono;
     
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
     * Constructor
     */
    public function __construct()
    {
        $this->idunidad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idtelefono = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set faxcentro
     *
     * @param string $faxcentro
     * @return Centrounidad
     */
    public function setFaxcentro($faxcentro)
    {
        $this->faxcentro = $faxcentro;
    
        return $this;
    }

    /**
     * Get faxcentro
     *
     * @return string 
     */
    public function getFaxcentro()
    {
        return $this->faxcentro;
    }

    /**
     * Set pbxcentro
     *
     * @param string $pbxcentro
     * @return Centrounidad
     */
    public function setPbxcentro($pbxcentro)
    {
        $this->pbxcentro = $pbxcentro;
    
        return $this;
    }

    /**
     * Get pbxcentro
     *
     * @return string 
     */
    public function getPbxcentro()
    {
        return $this->pbxcentro;
    }

    /**
     * Set emailcentro
     *
     * @param string $emailcentro
     * @return Centrounidad
     */
    public function setEmailcentro($emailcentro)
    {
        $this->emailcentro = $emailcentro;
    
        return $this;
    }

    /**
     * Get emailcentro
     *
     * @return string 
     */
    public function getEmailcentro()
    {
        return $this->emailcentro;
    }

     /**
     * Add idtelefono
     *
     * @param \SIGESRHI\AdminBundle\Entity\Telefono $idtelefono
     * @return Centrounidad
     */
    public function addIdtelefono(\SIGESRHI\AdminBundle\Entity\Telefono $idtelefono)
    {
        $this->idtelefono[] = $idtelefono;
    
        return $this;
    }

    /**
     * Remove idtelefono
     *
     * @param \SIGESRHI\AdminBundle\Entity\Telefono $idtelefono
     */
    public function removeIdtelefono(\SIGESRHI\AdminBundle\Entity\Telefono $idtelefono)
    {
        $this->idtelefono->removeElement($idtelefono);
    }

    /**
     * Get idtelefono
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtelefono()
    {
        return $this->idtelefono;
    }

}