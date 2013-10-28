<?php

namespace SIGESRHI\ExpedienteBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Repositorio\ExpedienteRepository")
 */
class Expediente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="expediente_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaexpediente", type="date", nullable=false)
     */
    private $fechaexpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoexpediente", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo de expediente")
     * @Assert\Length(
     * max = "1",
     * maxMessage = "El tipo de expediente no debe exceder los {{limit}} caracteres"
     * )
     */
    private $tipoexpediente;
    
    public function __toString(){
        return $this->getTipoexpediente();
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
     * Set fechaexpediente
     *
     * @param \DateTime $fechaexpediente
     * @return Expediente
     */
    public function setFechaexpediente($fechaexpediente)
    {
        $this->fechaexpediente = $fechaexpediente;
    
        return $this;
    }

    /**
     * Get fechaexpediente
     *
     * @return \DateTime 
     */
    public function getFechaexpediente()
    {
        return $this->fechaexpediente;
    }

    /**
     * Set tipoexpediente
     *
     * @param string $tipoexpediente
     * @return Expediente
     */
    public function setTipoexpediente($tipoexpediente)
    {
        $this->tipoexpediente = $tipoexpediente;
    
        return $this;
    }

    /**
     * Get tipoexpediente
     *
     * @return string 
     */
    public function getTipoexpediente()
    {
        return $this->tipoexpediente;
    }


public function __construct(){

$this->Docs_expediente = new ArrayCollection();
}

/********* Documentos de Expediente *****************/
    
    /**
     * @ORM\OneToMany(targetEntity="Docexpediente", mappedBy="idexpediente", cascade={"persist", "remove"})
     */
    protected $Docs_expediente;

   /**
     * Get Docs_expediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
  /*  public function getDocs_expediente()
    {
        return $this->Docs_expediente;
    }

  */
    public function setDocsexpediente(\Doctrine\Common\Collections\Collection $dexpedientes)
    {
        $this->Docs_expediente = $dexpedientes;

        foreach ($dexpedientes as $dexpediente) {
        $dexpediente->setIdexpediente($this); 
    }   
        }
    
 

    /**
     * Add Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     * @return Expediente
     */
  /*  public function addDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente[] = $docsExpediente;
    
        return $this;
    }
*/
    /**
     * Remove Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     */
  /*  public function removeDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente->removeElement($docsExpediente);
    }
*/
    /**
     * Get Docs_expediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocsExpediente()
    {
        return $this->Docs_expediente;
    }
}