<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Competencia
 *
 * @ORM\Table(name="competencia")
 * @ORM\Entity
 */
class Competencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="competencia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecompetencia", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de Habilidad")
     * @Assert\Length(
     * max = "255",
     * maxMessage = "El nombre de la habilidad no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrecompetencia;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idcompetencia")
     */
    private $idplaza;
    
    public function __toString() {
        return $this->nombrecompetencia;
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
    public function setNombrecompetencia($nombrecompetencia)
    {
        $this->nombrecompetencia = $nombrecompetencia;
    
        return $this;
    }

    /**
     * Get nombrehabilidad
     *
     * @return string 
     */
    public function getNombrecompetencia()
    {
        return $this->nombrecompetencia;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idplaza = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setIdplaza($idplaza)
    {
    if (count($idplaza) > 0) {
        foreach ($idplaza as $i) {
            $this->addIdplaza($i);
        }
     }
    }
    
    /**
     * Add idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Marcoreferencia
     */
    public function addIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza)
    {
       $idplaza->setIdcompetencia($this);
       $this->idplaza->add($idplaza);
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