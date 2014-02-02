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
     * @ORM\Column(name="nombreconocimiento", type="string", length=200, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de conocimiento")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "El nombre del conocimiento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreconocimiento;
    
    /**
     * @ORM\OneToMany(targetEntity="Conocimientoplaza", mappedBy="idconocimiento")
     */
    private $idconocimientoplaza;

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
        $this->idconocimientoplaza = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idconocimientoplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza
     * @return Conocimiento
     */
    public function addIdconocimientoplaza(\SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza)
    {
        $this->idconocimientoplaza[] = $idconocimientoplaza;
    
        return $this;
    }

    /**
     * Remove idconocimientoplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza
     */
    public function removeIdconocimientoplaza(\SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza)
    {
        $this->idconocimientoplaza->removeElement($idconocimientoplaza);
    }

    /**
     * Get idconocimientoplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdconocimientoplaza()
    {
        return $this->idconocimientoplaza;
    }
}