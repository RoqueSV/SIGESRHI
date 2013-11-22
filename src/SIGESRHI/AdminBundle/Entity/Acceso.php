<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acceso
 *
 * @ORM\Table(name="acceso")
 * @ORM\Entity
 */
class Acceso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="acceso_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrepagina", type="string", length=150, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de pagina")
     * @Assert\Length(
     * max = "150",
     * maxMessage = "El nombre de pagina no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrepagina;

    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=200, nullable=false)
     * @Assert\NotNull(message="Debe ingresar una ruta para el acceso")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "La ruta no debe exceder los {{limit}} caracteres"
     * )
     */
    private $ruta;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\Group", mappedBy="idacceso")
     */
    private $idrol;

    /**
     * @var \Modulo
     *
     * @ORM\ManyToOne(targetEntity="Modulo",  inversedBy="idacceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmodulo", referencedColumnName="id")
     * })
     */
    private $idmodulo;

    /**
     * @var \Acceso
     *
     * @ORM\ManyToOne(targetEntity="Acceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idaccesosup", referencedColumnName="id")
     * })
     */
    private $idaccesosup;

    /**
      * @ORM\OneToMany(targetEntity="Acceso", mappedBy="idaccesosup")
      */

    private $idaccesohija;
    
       public function __toString()
    {
        return $this->getNombrepagina();
    }    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idrol = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombrepagina
     *
     * @param string $nombrepagina
     * @return Acceso
     */
    public function setNombrepagina($nombrepagina)
    {
        $this->nombrepagina = $nombrepagina;
    
        return $this;
    }

    /**
     * Get nombrepagina
     *
     * @return string 
     */
    public function getNombrepagina()
    {
        return $this->nombrepagina;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     * @return Acceso
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    
        return $this;
    }

    /**
     * Get ruta
     *
     * @return string 
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Add idrol
     *
     * @param \Application\Sonata\UserBundle\Entity\Group $idrol
     * @return Acceso
     */
    public function addIdrol(\Application\Sonata\UserBundle\Entity\Group $idrol)
    {
        $this->idrol[] = $idrol;
    
        return $this;
    }

    /**
     * Remove idrol
     *
     * @param \Application\Sonata\UserBundle\Entity\Group $idrol
     */
    public function removeIdrol(\Application\Sonata\UserBundle\Entity\Group $idrol)
    {
        $this->idrol->removeElement($idrol);
    }

    /**
     * Get idrol
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set idmodulo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Modulo $idmodulo
     * @return Acceso
     */
    public function setIdmodulo(\SIGESRHI\AdminBundle\Entity\Modulo $idmodulo = null)
    {
        $this->idmodulo = $idmodulo;
    
        return $this;
    }

    /**
     * Get idmodulo
     *
     * @return \SIGESRHI\AdminBundle\Entity\Modulo 
     */
    public function getIdmodulo()
    {
        return $this->idmodulo;
    }


    /**
     * Set idaccesosup
     *
     * @param \SIGESRHI\AdminBundle\Entity\Acceso $idaccesosup
     * @return Acceso
     */
    public function setIdaccesosup(\SIGESRHI\AdminBundle\Entity\Acceso $idaccesosup = null)
    {
        $this->idaccesosup = $idaccesosup;
    
        return $this;
    }

    /**
     * Get idaccesosup
     *
     * @return \SIGESRHI\AdminBundle\Entity\Acceso 
     */
    public function getIdaccesosup()
    {
        return $this->idaccesosup;
    }
}