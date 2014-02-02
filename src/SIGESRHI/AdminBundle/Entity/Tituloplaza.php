<?php
namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tituloplaza
 *
 * @ORM\Table(name="tituloplaza")
 * @ORM\Entity
 */
class Tituloplaza
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="tituloplaza_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Titulo
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Titulo", inversedBy="idtituloplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtitulo", referencedColumnName="id")
     * })
     */
    private $idtitulo;

    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza", inversedBy="idtituloplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="tipotitulo", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo del titulo")
     */
    private $tipotitulo;

    public function __toString(){
        return $this->getIdtitulo()->getNombretitulo()." - ".$this->getTipotitulo();
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
     * Set tipotitulo
     *
     * @param string $tipotitulo
     * @return Tituloplaza
     */
    public function setTipotitulo($tipotitulo)
    {
        $this->tipotitulo = $tipotitulo;
    
        return $this;
    }

    /**
     * Get tipotitulo
     *
     * @return string 
     */
    public function getTipotitulo()
    {
        return $this->tipotitulo;
    }

    /**
     * Set idtitulo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo
     * @return Tituloplaza
     */
    public function setIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo = null)
    {
        $this->idtitulo = $idtitulo;
    
        return $this;
    }

    /**
     * Get idtitulo
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Titulo 
     */
    public function getIdtitulo()
    {
        return $this->idtitulo;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Tituloplaza
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
}