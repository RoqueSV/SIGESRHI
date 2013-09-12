<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull(message="Debe ingresar un nombre de area")
     * @Assert\Length(
     *  max = "100",
     * maxMessage = "El area no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrearea;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionarea", type="string", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "El area no debe exceder los {{limit}} caracteres"
     * )
     */
    private $descripcionarea;
    
     /**
     * @ORM\OneToMany(targetEntity="Plaza", mappedBy="idarea")
     */
    private $idplaza;
   
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
     * @return Area
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