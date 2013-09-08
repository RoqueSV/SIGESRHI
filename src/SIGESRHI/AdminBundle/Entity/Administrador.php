<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Administrador
 *
 * @ORM\Table(name="administrador")
 * @ORM\Entity
 */
class Administrador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="administrador_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idrol", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar un rol")
     */
    private $idrol;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreadministrador", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre para el Administrador")
     * @Assert\MaxLength(25)
     */
    private $nombreadministrador;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidoadministrador", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un apellido para el administrador")
     * @Assert\MaxLength(25)
     */
    private $apellidoadministrador;

    /**
     * @var string
     *
     * @ORM\Column(name="emailadministrador", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un email para el administrador")
     * @Assert\Email(
     *     message = "El email '{{ value }}' no es valido."
     * )
     * @Assert\MaxLength(50)
     */
    private $emailadministrador;



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
     * Set idrol
     *
     * @param integer $idrol
     * @return Administrador
     */
    public function setIdrol($idrol)
    {
        $this->idrol = $idrol;
    
        return $this;
    }

    /**
     * Get idrol
     *
     * @return integer 
     */
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set nombreadministrador
     *
     * @param string $nombreadministrador
     * @return Administrador
     */
    public function setNombreadministrador($nombreadministrador)
    {
        $this->nombreadministrador = $nombreadministrador;
    
        return $this;
    }

    /**
     * Get nombreadministrador
     *
     * @return string 
     */
    public function getNombreadministrador()
    {
        return $this->nombreadministrador;
    }

    /**
     * Set apellidoadministrador
     *
     * @param string $apellidoadministrador
     * @return Administrador
     */
    public function setApellidoadministrador($apellidoadministrador)
    {
        $this->apellidoadministrador = $apellidoadministrador;
    
        return $this;
    }

    /**
     * Get apellidoadministrador
     *
     * @return string 
     */
    public function getApellidoadministrador()
    {
        return $this->apellidoadministrador;
    }

    /**
     * Set emailadministrador
     *
     * @param string $emailadministrador
     * @return Administrador
     */
    public function setEmailadministrador($emailadministrador)
    {
        $this->emailadministrador = $emailadministrador;
    
        return $this;
    }

    /**
     * Get emailadministrador
     *
     * @return string 
     */
    public function getEmailadministrador()
    {
        return $this->emailadministrador;
    }
}