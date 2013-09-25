<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Telefono
 *
 * @ORM\Table(name="telefono")
 * @ORM\Entity
 */
class Telefono
{
	/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="telefono_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numtelefono", type="string", length=8, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un número telefonico")
     * @Assert\Length(max="8")
     */
    private $numtelefono;


    public function __toString(){
        return $this->getNumtelefono();
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
     * Set numtelefono
     *
     * @param string $numtelefono
     * @return Telefono
     */
    public function setNumtelefono($numtelefono)
    {
        $this->numtelefono = $numtelefono;
    
        return $this;
    }

    /**
     * Get numtelefono
     *
     * @return string 
     */
    public function getNumtelefono()
    {
        return $this->numtelefono;
    }

}