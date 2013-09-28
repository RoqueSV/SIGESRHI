<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Idioma
 *
 * @ORM\Table(name="idioma")
 * @ORM\Entity
 */
class Idioma
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="idioma_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreidioma", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del idioma")
     * @Assert\Length(
     * max = "25",
     * maxMessage = "El nombre del idioma no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreidioma;

    /**
     * @var string
     *
     * @ORM\Column(name="nivelescribe", type="string", length=10, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nivel de escritura")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El nivel de escritura no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nivelescribe;

    /**
     * @var string
     *
     * @ORM\Column(name="nivelhabla", type="string", length=10, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nivel habla")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El nivel habla no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nivelhabla;

    /**
     * @var string
     *
     * @ORM\Column(name="nivellee", type="string", length=10, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nivel lectura")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El nivel lectura no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nivellee;

    /**
     * @var \Solicitudempleo
     *
     * @ORM\ManyToOne(targetEntity="Solicitudempleo", inversedBy="Idiomas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsolicitudempleo", referencedColumnName="id")
     * })
     */
    private $idsolicitudempleo;



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
     * @return Idioma
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
     * Set nivelescribe
     *
     * @param string $nivelescribe
     * @return Idioma
     */
    public function setNivelescribe($nivelescribe)
    {
        $this->nivelescribe = $nivelescribe;
    
        return $this;
    }

    /**
     * Get nivelescribe
     *
     * @return string 
     */
    public function getNivelescribe()
    {
        return $this->nivelescribe;
    }

    /**
     * Set nivelhabla
     *
     * @param string $nivelhabla
     * @return Idioma
     */
    public function setNivelhabla($nivelhabla)
    {
        $this->nivelhabla = $nivelhabla;
    
        return $this;
    }

    /**
     * Get nivelhabla
     *
     * @return string 
     */
    public function getNivelhabla()
    {
        return $this->nivelhabla;
    }

    /**
     * Set nivellee
     *
     * @param string $nivellee
     * @return Idioma
     */
    public function setNivellee($nivellee)
    {
        $this->nivellee = $nivellee;
    
        return $this;
    }

    /**
     * Get nivellee
     *
     * @return string 
     */
    public function getNivellee()
    {
        return $this->nivellee;
    }

    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Idioma
     */
    public function setIdsolicitudempleo(\SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo = null)
    {
        $this->idsolicitudempleo = $idsolicitudempleo;
    
        return $this;
    }

    /**
     * Get idsolicitudempleo
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo 
     */
    public function getIdsolicitudempleo()
    {
        return $this->idsolicitudempleo;
    }
}