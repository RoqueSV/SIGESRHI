<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Resultados
 *
 * @ORM\Table(name="resultados")
 * @ORM\Entity
 */
class Resultados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="resultados_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreresultado", type="text", length=350, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de area")
     * @Assert\Length(
     *  max = "300",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreresultado;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idresultado")
     */
    
    private $idplaza;
   
    public function __toString() {
  return $this->nombreresultado;
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
     * Set nombreresultado
     *
     * @param string $nombreresultado
     * @return Resultados
     */
    public function setNombreresultado($nombreresultado)
    {
        $this->nombreresultado = $nombreresultado;
    
        return $this;
    }

    /**
     * Get nombreresultado
     *
     * @return string 
     */
    public function getNombreresultado()
    {
        return $this->nombreresultado;
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
     * @return Resultados
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