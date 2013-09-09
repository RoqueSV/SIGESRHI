<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conocimiento
 *
 * @ORM\Table(name="conocimiento")
 * @ORM\Entity
 */
class Conocimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="conocimiento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreconocimiento", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de conocimiento")
     * @Assert\Length(max= "50")
     */
    private $nombreconocimiento;
    
        /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idconocimiento")
     */
    private $idplaza;

        public function __toString() {
  return $this->nombreconocimiento;
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
     * Set nombreconocimiento
     *
     * @param string $nombreconocimiento
     * @return Conocimiento
     */
    public function setNombreconocimiento($nombreconocimiento)
    {
        $this->nombreconocimiento = $nombreconocimiento;
    
        return $this;
    }

    /**
     * Get nombreconocimiento
     *
     * @return string 
     */
    public function getNombreconocimiento()
    {
        return $this->nombreconocimiento;
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
     * @return Conocimiento
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