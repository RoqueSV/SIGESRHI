<?php

namespace SIGESRHI\ExpedienteBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Repositorio\ExpedienteRepository")
 * @GRID\Source(columns="id,idempleado.codigoempleado, idsolicitudempleo.nombres, idsolicitudempleo.primerapellido, idsolicitudempleo.segundoapellido, idempleado.idcontratacion.idplaza.nombreplaza, idsegurovida.id", groups={"grupo_segurovida"})
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
     * @GRID\Column(filterable=false, groups="grupo_segurovida", visible=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaexpediente", type="date", nullable=false)
     * @GRID\Column(filterable=false, groups="grupo_segurovida", visible=false)
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

    /**
     * @ORM\OneToOne(targetEntity="Empleado", mappedBy="idexpediente")
     * @GRID\Column(field="idempleado.codigoempleado", groups="grupo_segurovida" ,title="Codigo", filter="select", selectFrom="source", searchOnClick="true", joinType="inner")
     * @GRID\Column(field="idempleado.idcontratacion.idplaza.nombreplaza", type="text", title="Plaza", filterable=false)
     */
    private $idempleado;

    /**
     * @var \Solicitudempleo
     * @ORM\OneToOne(targetEntity="Solicitudempleo", mappedBy="idexpediente")
     * @GRID\Column(field="idsolicitudempleo.nombres", groups="grupo_segurovida" ,title="Nombres", filterable=false, joinType="inner")
     * @GRID\Column(field="idsolicitudempleo.primerapellido", groups="grupo_segurovida" ,title="Primer Apellido", filterable=false, joinType="inner")
     * @GRID\Column(field="idsolicitudempleo.segundoapellido", groups="grupo_segurovida" ,title="Segundo Apellido", filterable=false, joinType="inner")
     */
    private $idsolicitudempleo;

    /**
     * @ORM\OneToMany(targetEntity="Segurovida", mappedBy="idexpediente")
     * @GRID\Column(field="idsegurovida.id", filterable=false, groups="grupo_segurovida", visible=false)
     */
    private $idsegurovida;

    /*
     * @ORM\OneToOne(targetEntity="Pruebapsicologica", mappedBy="idexpediente")
     */
    private $idpruebapsicologica;
    
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

  
    public function setDocsexpediente(\Doctrine\Common\Collections\Collection $dexpedientes)
    {
        $this->Docs_expediente = $dexpedientes;

        foreach ($dexpedientes as $dexpediente) {
        $dexpediente->setIdexpediente($this); 
    }   
        }
    
    
    /**
     * Get Docs_expediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocsExpediente()
    {
        return $this->Docs_expediente;
    }


    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Expediente
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

    /**
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Expediente
     */
    public function setIdempleado(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado = null)
    {
        $this->idempleado = $idempleado;
    
        return $this;
    }

    /**
     * Get idempleado
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdempleado()
    {
        return $this->idempleado;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idsegurovida = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idsegurovida
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida
     * @return Expediente
     */
    public function addIdsegurovida(\SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida)
    {
        $this->idsegurovida[] = $idsegurovida;
    
        return $this;
    }

    /**
     * Remove idsegurovida
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida
     */
    public function removeIdsegurovida(\SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida)
    {
        $this->idsegurovida->removeElement($idsegurovida);
    }

    /**
     * Get idsegurovida
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdsegurovida()
    {
        return $this->idsegurovida;
    }
}