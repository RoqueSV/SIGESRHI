<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Marcoreferencia
 *
 * @ORM\Table(name="marcoreferencia")
 * @ORM\Entity
 */
class Marcoreferencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="marcoreferencia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombremarcoref", type="string", length=250, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripción del marco de referencia")
     * @Assert\Length(
     * max = "250",
     * maxMessage = "El marco de referencia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombremarcoref;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Plaza", mappedBy="idmarcoreferencia")
     */
    private $idplaza;

    public function __toString() {
      return $this->nombremarcoref;
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
     * Set nombremarcoref
     *
     * @param string $nombremarcoref
     * @return Marcoreferencia
     */
    public function setNombremarcoref($nombremarcoref)
    {
        $this->nombremarcoref = $nombremarcoref;
    
        return $this;
    }

    /**
     * Get nombremarcoref
     *
     * @return string 
     */
    public function getNombremarcoref()
    {
        return $this->nombremarcoref;
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
       $idplaza->setIdmarcoreferencia($this);
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