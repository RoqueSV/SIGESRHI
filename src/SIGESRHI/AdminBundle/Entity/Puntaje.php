<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Puntaje
 *
 * @ORM\Table(name="puntaje")
 * @ORM\Entity
 */
class Puntaje
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="puntaje_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrepuntaje", type="string", length=15, nullable=false)
     */
    private $nombrepuntaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="puntajemin", type="integer", nullable=false)
     */
    private $puntajemin;

    /**
     * @var integer
     *
     * @ORM\Column(name="puntajemax", type="integer", nullable=false)
     */
    private $puntajemax;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Formularioevaluacion")
     * @ORM\JoinTable(name="formulariopuntaje",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idpuntaje", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idformulario", referencedColumnName="id")
     *   }
     * )
     */
    private $idformulario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idformulario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombrepuntaje
     *
     * @param string $nombrepuntaje
     * @return Puntaje
     */
    public function setNombrepuntaje($nombrepuntaje)
    {
        $this->nombrepuntaje = $nombrepuntaje;
    
        return $this;
    }

    /**
     * Get nombrepuntaje
     *
     * @return string 
     */
    public function getNombrepuntaje()
    {
        return $this->nombrepuntaje;
    }

    /**
     * Set puntajemin
     *
     * @param integer $puntajemin
     * @return Puntaje
     */
    public function setPuntajemin($puntajemin)
    {
        $this->puntajemin = $puntajemin;
    
        return $this;
    }

    /**
     * Get puntajemin
     *
     * @return integer 
     */
    public function getPuntajemin()
    {
        return $this->puntajemin;
    }

    /**
     * Set puntajemax
     *
     * @param integer $puntajemax
     * @return Puntaje
     */
    public function setPuntajemax($puntajemax)
    {
        $this->puntajemax = $puntajemax;
    
        return $this;
    }

    /**
     * Get puntajemax
     *
     * @return integer 
     */
    public function getPuntajemax()
    {
        return $this->puntajemax;
    }

    /**
     * Add idformulario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario
     * @return Puntaje
     */
    public function addIdformulario(\SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario)
    {
        $this->idformulario[] = $idformulario;
    
        return $this;
    }

    /**
     * Remove idformulario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario
     */
    public function removeIdformulario(\SIGESRHI\AdminBundle\Entity\Formularioevaluacion $idformulario)
    {
        $this->idformulario->removeElement($idformulario);
    }

    /**
     * Get idformulario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdformulario()
    {
        return $this->idformulario;
    }
}