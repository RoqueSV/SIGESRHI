<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Otrosidiomas
 *
 * @ORM\Table(name="otrosidiomas")
 * @ORM\Entity
 */
class Otrosidiomas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="otrosidiomas_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreidioma", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de idioma")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "El nombre del idioma no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreidioma;
    
    /**
     * @ORM\OneToMany(targetEntity="Idiomasplaza", mappedBy="idotrosidiomas")
     */
    private $ididiomasplaza;
     

    public function __toString() {
        return $this->nombreidioma;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ididiomasplaza = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreidioma
     *
     * @param string $nombreidioma
     * @return Otrosidiomas
     */
    public function setNombreidioma($nombreidioma)
    {
        $this->nombreidioma = $nombreidioma;
    
        return $this;
    }

    /**
     * Get nombreidioma
     *
     * @return string 
     */
    public function getNombreidioma()
    {
        return $this->nombreidioma;
    }

    /**
     * Add ididiomasplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza
     * @return Otrosidiomas
     */
    public function addIdidiomasplaza(\SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza)
    {
        $this->ididiomasplaza[] = $ididiomasplaza;
    
        return $this;
    }

    /**
     * Remove ididiomasplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza
     */
    public function removeIdidiomasplaza(\SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza)
    {
        $this->ididiomasplaza->removeElement($ididiomasplaza);
    }

    /**
     * Get ididiomasplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdidiomasplaza()
    {
        return $this->ididiomasplaza;
    }
}