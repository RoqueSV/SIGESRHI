<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Accionpersonal
 *
 * @ORM\Table(name="accionpersonal")
 * @ORM\Entity
 * @UniqueEntity("numacuerdo")
 * @GRID\Source(columns="id, idtipoaccion.nombretipoaccion, numacuerdo, fecharegistroaccion, idexpediente.id, motivoaccion", groups={"grupo_consultar_acuerdo"})
 */
class Accionpersonal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="accionpersonal_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_consultar_acuerdo"}, visible=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistroaccion", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de registro")
     * @GRID\Column(filterable=true, groups={"grupo_consultar_acuerdo"}, visible=true, type="date", format="Y-m-d", title="Fecha Registro", align="center", operators={"gte", "like", "eq", "lte"}, operatorsVisible=true)
     */
    private $fecharegistroaccion;

    /**
     * @var string
     *
     * @ORM\Column(name="motivoaccion", type="string", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el motivo de la accion")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "El motivo de la accion no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_consultar_acuerdo"}, visible=true, title="Descripción")
     */
    private $motivoaccion;

    /**
     * @var \Tipoaccion
     *
     * @ORM\ManyToOne(targetEntity="Tipoaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtipoaccion", referencedColumnName="id")
     * })
     * @GRID\Column(field="idtipoaccion.nombretipoaccion", groups={"grupo_consultar_acuerdo"} ,visible=false, joinType="inner", filterable=true, title="Tipo de acuerdo", filter="select", operators={"like"}, operatorsVisible=false)
     */
    private $idtipoaccion;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente", inversedBy="idaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     * @GRID\Column(field="idexpediente.id",groups={"grupo_consultar_acuerdo"} ,visible=false, joinType="inner", filterable=false)
     */
    private $idexpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="numacuerdo", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el numero de acuerdo.")
     * @Assert\Length(
     * max = "15",
     * maxMessage = "El numero de acuerdo no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_consultar_acuerdo"}, visible=true, title="# Acuerdo", align="center")
     */
    private $numacuerdo;

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
     * Set fecharegistroaccion
     *
     * @param \DateTime $fecharegistroaccion
     * @return Accionpersonal
     */
    public function setFecharegistroaccion($fecharegistroaccion)
    {
        $this->fecharegistroaccion = $fecharegistroaccion;
    
        return $this;
    }

    /**
     * Get fecharegistroaccion
     *
     * @return \DateTime 
     */
    public function getFecharegistroaccion()
    {
        return $this->fecharegistroaccion;
    }

    /**
     * Set motivoaccion
     *
     * @param string $motivoaccion
     * @return Accionpersonal
     */
    public function setMotivoaccion($motivoaccion)
    {
        $this->motivoaccion = $motivoaccion;
    
        return $this;
    }

    /**
     * Get motivoaccion
     *
     * @return string 
     */
    public function getMotivoaccion()
    {
        return $this->motivoaccion;
    }

    /**
     * Set idtipoaccion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Tipoaccion $idtipoaccion
     * @return Accionpersonal
     */
    public function setIdtipoaccion(\SIGESRHI\ExpedienteBundle\Entity\Tipoaccion $idtipoaccion = null)
    {
        $this->idtipoaccion = $idtipoaccion;
    
        return $this;
    }

    /**
     * Get idtipoaccion
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Tipoaccion 
     */
    public function getIdtipoaccion()
    {
        return $this->idtipoaccion;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Accionpersonal
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

    /**
     * Set tipoacuerdo
     *
     * @param string $tipoacuerdo
     * @return Accionpersonal
     */
    public function setTipoacuerdo($tipoacuerdo)
    {
        $this->tipoacuerdo = $tipoacuerdo;
    
        return $this;
    }

    /**
     * Get tipoacuerdo
     *
     * @return string 
     */
    public function getTipoacuerdo()
    {
        return $this->tipoacuerdo;
    }

    /**
     * Set numacuerdo
     *
     * @param string $numacuerdo
     * @return Accionpersonal
     */
    public function setNumacuerdo($numacuerdo)
    {
        $this->numacuerdo = $numacuerdo;
    
        return $this;
    }

    /**
     * Get numacuerdo
     *
     * @return string 
     */
    public function getNumacuerdo()
    {
        return $this->numacuerdo;
    }
}