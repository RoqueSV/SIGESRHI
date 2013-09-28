<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Capacitador
 *
 * @ORM\Table(name="capacitador")
 * @ORM\Entity
 */
class Capacitador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="capacitador_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecapacitador", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del capacitador")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del capacitador no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrecapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonocapacitador", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono")
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El numero de telefono no debe exceder los {{limit}} caracteres"
     * )
     */
    private $telefonocapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="correocapacitador", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la correo")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El correo del capacitador no debe exceder los {{limit}} caracteres"
     * )
     * @Assert\Email(
     *     message = "El correo del capacitador '{{ value }}' no es un correo valido."
     * )
     */
    private $correocapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="tematicacapacitador", type="string", length=250, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la tematica")
     * @Assert\Length(
     * max = "250",
     * maxMessage = "La tematica del capacitador no debe exceder los {{limit}} caracteres"
     * )
     */
    private $tematicacapacitador;

    /**
     * @var \Institucioncapacitadora
     *
     * @ORM\ManyToOne(targetEntity="Institucioncapacitadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idinstitucion", referencedColumnName="id")
     * })
     */
    private $idinstitucion;



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
     * Set nombrecapacitador
     *
     * @param string $nombrecapacitador
     * @return Capacitador
     */
    public function setNombrecapacitador($nombrecapacitador)
    {
        $this->nombrecapacitador = $nombrecapacitador;
    
        return $this;
    }

    /**
     * Get nombrecapacitador
     *
     * @return string 
     */
    public function getNombrecapacitador()
    {
        return $this->nombrecapacitador;
    }

    /**
     * Set telefonocapacitador
     *
     * @param string $telefonocapacitador
     * @return Capacitador
     */
    public function setTelefonocapacitador($telefonocapacitador)
    {
        $this->telefonocapacitador = $telefonocapacitador;
    
        return $this;
    }

    /**
     * Get telefonocapacitador
     *
     * @return string 
     */
    public function getTelefonocapacitador()
    {
        return $this->telefonocapacitador;
    }

    /**
     * Set correocapacitador
     *
     * @param string $correocapacitador
     * @return Capacitador
     */
    public function setCorreocapacitador($correocapacitador)
    {
        $this->correocapacitador = $correocapacitador;
    
        return $this;
    }

    /**
     * Get correocapacitador
     *
     * @return string 
     */
    public function getCorreocapacitador()
    {
        return $this->correocapacitador;
    }

    /**
     * Set tematicacapacitador
     *
     * @param string $tematicacapacitador
     * @return Capacitador
     */
    public function setTematicacapacitador($tematicacapacitador)
    {
        $this->tematicacapacitador = $tematicacapacitador;
    
        return $this;
    }

    /**
     * Get tematicacapacitador
     *
     * @return string 
     */
    public function getTematicacapacitador()
    {
        return $this->tematicacapacitador;
    }

    /**
     * Set idinstitucion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Institucioncapacitadora $idinstitucion
     * @return Capacitador
     */
    public function setIdinstitucion(\SIGESRHI\AdminBundle\Entity\Institucioncapacitadora $idinstitucion = null)
    {
        $this->idinstitucion = $idinstitucion;
    
        return $this;
    }

    /**
     * Get idinstitucion
     *
     * @return \SIGESRHI\AdminBundle\Entity\Institucioncapacitadora 
     */
    public function getIdinstitucion()
    {
        return $this->idinstitucion;
    }
}