<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Otrosaspectos
 *
 * @ORM\Table(name="otrosaspectos")
 * @ORM\Entity
 */
class Otrosaspectos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="otrosaspectos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreotrosaspectos", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre")
     * @Assert\Length(
     * max = "255",
     * maxMessage = "La descripcion no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreotrosaspectos;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idotrosaspectos")
     */
    private $idplaza;

    public function __toString(){
        return $this->getNombreotrosaspectos();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idplaza = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreotrosaspectos
     *
     * @param string $nombreotrosaspectos
     * @return Otrosaspectos
     */
    public function setNombreotrosaspectos($nombreotrosaspectos)
    {
        $this->nombreotrosaspectos = $nombreotrosaspectos;
    
        return $this;
    }

    /**
     * Get nombreotrosaspectos
     *
     * @return string 
     */
    public function getNombreotrosaspectos()
    {
        return $this->nombreotrosaspectos;
    }

    /**
     * Add idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Otrosaspectos
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