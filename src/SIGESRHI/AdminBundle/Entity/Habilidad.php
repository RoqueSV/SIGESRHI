<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Habilidad
 *
 * @ORM\Table(name="habilidad")
 * @ORM\Entity
 */
class Habilidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="habilidad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrehabilidad", type="string", length=75, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de Habilidad")
     * @Assert\Length(
     * max = "75",
     * maxMessage = "El nombre de la habilidad no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrehabilidad;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idhabilidad")
     */
    private $idplaza;
    
        public function __toString() {
        return $this->nombrehabilidad;
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
     * Set nombrehabilidad
     *
     * @param string $nombrehabilidad
     * @return Habilidad
     */
    public function setNombrehabilidad($nombrehabilidad)
    {
        $this->nombrehabilidad = $nombrehabilidad;
    
        return $this;
    }

    /**
     * Get nombrehabilidad
     *
     * @return string 
     */
    public function getNombrehabilidad()
    {
        return $this->nombrehabilidad;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idplaza = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Habilidad
     */
    public function addIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza)
    {
        $this->idplaza[] = $idplaza;
    
        return $this;
    }

    /**
     * Remove idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     */
    public function removeIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza)
    {
        $this->idplaza->removeElement($idplaza);
    }

    /**
     * Get idplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }
}