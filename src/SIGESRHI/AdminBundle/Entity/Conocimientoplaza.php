<?php
namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conocimientoplaza
 *
 * @ORM\Table(name="conocimientoplaza")
 * @ORM\Entity
 */
class Conocimientoplaza
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="conocimientoplaza_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Conocimiento
     *
     * @ORM\ManyToOne(targetEntity="Conocimiento", inversedBy="idconocimientoplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idconocimiento", referencedColumnName="id")
     * })
     */
    private $idconocimiento;

    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza", inversedBy="idconocimientoplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoconocimiento", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo del conocimiento")
     */
    private $tipoconocimiento;

    public function __toString(){
        return $this->getIdconocimiento()->getNombreconocimiento()." - ".$this->getTipoconocimiento();
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
     * Set tipoconocimiento
     *
     * @param string $tipoconocimiento
     * @return Conocimientoplaza
     */
    public function setTipoconocimiento($tipoconocimiento)
    {
        $this->tipoconocimiento = $tipoconocimiento;
    
        return $this;
    }

    /**
     * Get tipoconocimiento
     *
     * @return string 
     */
    public function getTipoconocimiento()
    {
        return $this->tipoconocimiento;
    }

    /**
     * Set idconocimiento
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento
     * @return Conocimientoplaza
     */
    public function setIdconocimiento(\SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento = null)
    {
        $this->idconocimiento = $idconocimiento;
    
        return $this;
    }

    /**
     * Get idconocimiento
     *
     * @return \SIGESRHI\AdminBundle\Entity\Conocimiento 
     */
    public function getIdconocimiento()
    {
        return $this->idconocimiento;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Conocimientoplaza
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