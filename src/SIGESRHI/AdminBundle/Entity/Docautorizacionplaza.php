<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docautorizacionplaza
 *
 * @ORM\Table(name="docautorizacionplaza")
 * @ORM\Entity
 */
class Docautorizacionplaza
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docautorizacionplaza_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numrefdoc", type="string", length=20, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el numero de referencia")
     * @Assert\Length(
     * max = "20",
     * maxMessage = "El numero de referencia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $numrefdoc;

    /**
     * @var string
     *
     * @ORM\Column(name="accionplaza", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la accion")
     */
    private $accionplaza;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaautorizacionplaza", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de autorizacion de la plaza")
     * @Assert\DateTime()
     */
    private $fechaautorizacionplaza;

    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza", inversedBy="iddocautorizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;



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
     * Set numrefdoc
     *
     * @param string $numrefdoc
     * @return Docautorizacionplaza
     */
    public function setNumrefdoc($numrefdoc)
    {
        $this->numrefdoc = $numrefdoc;
    
        return $this;
    }

    /**
     * Get numrefdoc
     *
     * @return string 
     */
    public function getNumrefdoc()
    {
        return $this->numrefdoc;
    }

    /**
     * Set accionplaza
     *
     * @param string $accionplaza
     * @return Docautorizacionplaza
     */
    public function setAccionplaza($accionplaza)
    {
        $this->accionplaza = $accionplaza;
    
        return $this;
    }

    /**
     * Get accionplaza
     *
     * @return string 
     */
    public function getAccionplaza()
    {
        return $this->accionplaza;
    }

    /**
     * Set fechaautorizacionplaza
     *
     * @param \DateTime $fechaautorizacionplaza
     * @return Docautorizacionplaza
     */
    public function setFechaautorizacionplaza($fechaautorizacionplaza)
    {
        $this->fechaautorizacionplaza = $fechaautorizacionplaza;
    
        return $this;
    }

    /**
     * Get fechaautorizacionplaza
     *
     * @return \DateTime 
     */
    public function getFechaautorizacionplaza()
    {
        return $this->fechaautorizacionplaza;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Docautorizacionplaza
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