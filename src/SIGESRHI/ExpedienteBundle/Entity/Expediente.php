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
 * @GRID\Source(columns="id,idempleado.codigoempleado,idsolicitudempleo.nombrecompleto,idempleado.idcontratacion.idplaza.nombreplaza, idsegurovida.id, tipoexpediente", groups={"grupo_segurovida"})
 * @GRID\Source(columns="id,idsolicitudempleo.nombrecompleto, idsolicitudempleo.idplaza.nombreplaza, tipoexpediente", groups={"grupo_contratacion"})
 * @GRID\Source(columns="id, idsolicitudempleo.numsolicitud, idsolicitudempleo.nombrecompleto, idsolicitudempleo.fecharegistro, tipoexpediente", groups={"grupo_docdigital"})
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
     * @GRID\Column(filterable=false, groups={"grupo_segurovida","grupo_contratacion","grupo_docdigital"}, visible=false)
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
     * @GRID\Column(filterable=false, groups={"grupo_segurovida","grupo_contratacion", "grupo_docdigital"}, visible=false)
     */
    private $tipoexpediente;

    /**
     * @ORM\OneToOne(targetEntity="Empleado", mappedBy="idexpediente")
     * @GRID\Column(field="idempleado.codigoempleado", groups="grupo_segurovida" ,title="Codigo", filter="input", align="center", operators={"like"}, operatorsVisible=false, joinType="inner")
     * @GRID\Column(field="idempleado.idcontratacion.idplaza.nombreplaza", groups="grupo_segurovida",type="text", title="Plaza", filterable=false, joinType="inner")
     */
    private $idempleado;

    /**
     * @var \Solicitudempleo
     * @ORM\OneToOne(targetEntity="Solicitudempleo", mappedBy="idexpediente")
     * @GRID\Column(field="idsolicitudempleo.idplaza.nombreplaza", groups="grupo_contratacion",type="text", title="Plaza solicitada", operators={"like"}, operatorsVisible=false, joinType="inner")
     * @GRID\Column(field="idsolicitudempleo.nombrecompleto", groups={"grupo_segurovida","grupo_contratacion", "grupo_docdigital"} ,title="Nombres", operators={"eq","like"}, joinType="inner")
     * @GRID\Column(field="idsolicitudempleo.fecharegistro", type="date", groups={"grupo_docdigital"}, title="Registrado",  joinType="inner", filterable=false)
     * @GRID\Column(field="idsolicitudempleo.numsolicitud", groups={"grupo_docdigital"}, title="Num. Solicitud", joinType="inner", filterable=false)
     */
    private $idsolicitudempleo;

    /**
     * @ORM\OneToMany(targetEntity="Segurovida", mappedBy="idexpediente")
     * @GRID\Column(field="idsegurovida.id", filterable=false, groups="grupo_segurovida", visible=false)
     */
    private $idsegurovida;

    /**
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
    $this->idsegurovida = new \Doctrine\Common\Collections\ArrayCollection();
    }

/********* Documentos de Expediente *****************/
    

    /**
     * @ORM\OneToMany(targetEntity="Docexpediente", mappedBy="idexpediente", cascade={"persist", "remove"})
     */
    protected $Docs_expediente;

/********* Documentos personales *********************/

    /**
    * @ORM\OneToMany(targetEntity="Docpersonal", mappedBy="idexpediente", cascade={"persist", "remove"})
    *
    */ 
    protected $Docs_personal;
     
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

    /**
     * Add Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     * @return Expediente
     */
    public function addDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente[] = $docsExpediente;
    
        return $this;
    }

    /**
     * Remove Docs_expediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente
     */
    public function removeDocsExpediente(\SIGESRHI\ExpedienteBundle\Entity\Docexpediente $docsExpediente)
    {
        $this->Docs_expediente->removeElement($docsExpediente);
    }

    /**
     * Set idpruebapsicologica
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica $idpruebapsicologica
     * @return Expediente
     */
    public function setIdpruebapsicologica(\SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica $idpruebapsicologica = null)
    {
        $this->idpruebapsicologica = $idpruebapsicologica;
    
        return $this;
    }

    /**
     * Get idpruebapsicologica
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica 
     */
    public function getIdpruebapsicologica()
    {
        return $this->idpruebapsicologica;
    }

    /**
     * Add Docs_personal
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal
     * @return Expediente
     */
    public function addDocsPersonal(\SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal)
    {
        $this->Docs_personal[] = $docsPersonal;
    
        return $this;
    }

    /**
     * Remove Docs_personal
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal
     */
    public function removeDocsPersonal(\SIGESRHI\ExpedienteBundle\Entity\Docpersonal $docsPersonal)
    {
        $this->Docs_personal->removeElement($docsPersonal);
    }

    /**
     * Get Docs_personal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocsPersonal()
    {
        return $this->Docs_personal;
    }
}