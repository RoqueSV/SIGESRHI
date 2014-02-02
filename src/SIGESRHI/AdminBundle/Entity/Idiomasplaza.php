<?php
namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Idiomasplaza
 *
 * @ORM\Table(name="idiomasplaza")
 * @ORM\Entity
 */
class Idiomasplaza
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="idiomasplaza_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Otrosidiomas
     *
     * @ORM\ManyToOne(targetEntity="Otrosidiomas", inversedBy="ididiomasplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idotrosidiomas", referencedColumnName="id")
     * })
     */
    private $idotrosidiomas;

    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza", inversedBy="ididiomasplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoidioma", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo del idioma")
     */
    private $tipoidioma;

    /**
     * @var string
     *
     * @ORM\Column(name="nivelidioma", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nivel")
     */
    private $nivelidioma;
   
    public function __toString(){
        return $this->getIdotrosidiomas()->getNombreidioma()." - ".$this->getTipoidioma()." - ".$this->getNivelidioma();
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
     * Set tipoidioma
     *
     * @param string $tipoidioma
     * @return Idiomasplaza
     */
    public function setTipoidioma($tipoidioma)
    {
        $this->tipoidioma = $tipoidioma;
    
        return $this;
    }

    /**
     * Get tipoidioma
     *
     * @return string 
     */
    public function getTipoidioma()
    {
        return $this->tipoidioma;
    }

    /**
     * Set idotrosidiomas
     *
     * @param \SIGESRHI\AdminBundle\Entity\Otrosidiomas $idotrosidiomas
     * @return Idiomasplaza
     */
    public function setIdotrosidiomas(\SIGESRHI\AdminBundle\Entity\Otrosidiomas $idotrosidiomas = null)
    {
        $this->idotrosidiomas = $idotrosidiomas;
    
        return $this;
    }

    /**
     * Get idotrosidiomas
     *
     * @return \SIGESRHI\AdminBundle\Entity\Otrosidiomas 
     */
    public function getIdotrosidiomas()
    {
        return $this->idotrosidiomas;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Idiomasplaza
     */
    public function setIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza = null)
    {
        $this->idplaza = $idplaza;
    
        return $this;
    }

    /**
     * Get idplaza
     *
     * @return \SIGESRHI\AdminBundle\Entity\Plaza 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }

    /**
     * Set nivelidioma
     *
     * @param string $nivelidioma
     * @return Idiomasplaza
     */
    public function setNivelidioma($nivelidioma)
    {
        $this->nivelidioma = $nivelidioma;
    
        return $this;
    }

    /**
     * Get nivelidioma
     *
     * @return string 
     */
    public function getNivelidioma()
    {
        return $this->nivelidioma;
    }
}