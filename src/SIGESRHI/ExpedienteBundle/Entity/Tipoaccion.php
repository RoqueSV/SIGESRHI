<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tipoaccion
 *
 * @ORM\Table(name="tipoaccion")
 * @ORM\Entity
 */
class Tipoaccion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="tipoaccion_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombretipoaccion", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del tipo de accion")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del tipo de accion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombretipoaccion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripciontipoaccion", type="string", length=150, nullable=true)
     * @Assert\Length(
     * max = "150",
     * maxMessage = "La descripcion de la accion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $descripciontipoaccion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoaccion", type="string", nullable=false)
     */
    private $tipoaccion;



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
     * Set nombretipoaccion
     *
     * @param string $nombretipoaccion
     * @return Tipoaccion
     */
    public function setNombretipoaccion($nombretipoaccion)
    {
        $this->nombretipoaccion = $nombretipoaccion;
    
        return $this;
    }

    /**
     * Get nombretipoaccion
     *
     * @return string 
     */
    public function getNombretipoaccion()
    {
        return $this->nombretipoaccion;
    }

    /**
     * Set descripciontipoaccion
     *
     * @param string $descripciontipoaccion
     * @return Tipoaccion
     */
    public function setDescripciontipoaccion($descripciontipoaccion)
    {
        $this->descripciontipoaccion = $descripciontipoaccion;
    
        return $this;
    }

    /**
     * Get descripciontipoaccion
     *
     * @return string 
     */
    public function getDescripciontipoaccion()
    {
        return $this->descripciontipoaccion;
    }

    /**
     * Set tipoaccion
     *
     * @param string $tipoaccion
     * @return Tipoaccion
     */
    public function setTipoaccion($tipoaccion)
    {
        $this->tipoaccion = $tipoaccion;
    
        return $this;
    }

    /**
     * Get tipoaccion
     *
     * @return string 
     */
    public function getTipoaccion()
    {
        return $this->tipoaccion;
    }
}