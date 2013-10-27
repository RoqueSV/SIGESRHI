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
     * @var string
     *
     * @ORM\Column(name="nombreadministrador", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre para el Administrador")
     * @Assert\Length(
     *  max = "25",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreadministrador;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidoadministrador", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un apellido para el administrador")
     * @Assert\Length(
     *  min = "3",
     *  max = "25",
     * minMessage = "El apellido debe tener {{limit}} caracteres o más",
     * maxMessage = "El apellido no debe exceder los {{limit}} caracteres"
     * )
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
     */
    private $emailadministrador;

    /**
     * @var \Usuario
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $idusuario;

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

    /**
     * Set idusuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuario
     * @return Empleado
     */
    public function setIdusuario(\Application\Sonata\UserBundle\Entity\User $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}