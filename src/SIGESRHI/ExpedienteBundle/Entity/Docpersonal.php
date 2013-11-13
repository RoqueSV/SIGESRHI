<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docpersonal
 *
 * @ORM\Table(name="docpersonal")
 * @ORM\Entity
 */
class Docpersonal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docpersonal_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocpersonal", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del documento")
     * @Assert\Length(
     * max = "25",
     * maxMessage = "El nombre del documento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombredocpersonal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="entregado", type="boolean", nullable=true)
     * @Assert\NotNull(message="Debe ingresar la opcion entregado")
     */
    private $entregado;

    /**
     * @var integer
     *
     * @ORM\Column(name="indice", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el indice")
     */
    private $indice;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente", inversedBy="Docs_personal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     */
    private $idexpediente;



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
     * Set nombredocpersonal
     *
     * @param string $nombredocpersonal
     * @return Docpersonal
     */
    public function setNombredocpersonal($nombredocpersonal)
    {
        $this->nombredocpersonal = $nombredocpersonal;
    
        return $this;
    }

    /**
     * Get nombredocpersonal
     *
     * @return string 
     */
    public function getNombredocpersonal()
    {
        return $this->nombredocpersonal;
    }

    /**
     * Set entregado
     *
     * @param boolean $entregado
     * @return Docpersonal
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;
    
        return $this;
    }

    /**
     * Get entregado
     *
     * @return boolean 
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set indice
     *
     * @param integer $indice
     * @return Docpersonal
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;
    
        return $this;
    }

    /**
     * Get indice
     *
     * @return integer 
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Docpersonal
     */
    public function setIdexpediente(\SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }
}