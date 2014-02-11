<?php

namespace SIGESRHI\PortalEmpleadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Solicitudcapacitacion
 *
 * @ORM\Table(name="solicitudcapacitacion")
 * @ORM\Entity
 * @GRID\Source(columns="id,aprobacionsolicitud,idcapacitacion.tematica,fechasolicitud",groups={"solEmpleado"})
 * @GRID\Source(columns="idempleado.idexpediente.idsolicitudempleo.nombrecompleto,id,fechasolicitud,aprobacionsolicitud",groups={"solicitud_empleado"})
 */
class Solicitudcapacitacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="solicitudcapacitacion_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(groups={"solEmpleado","solicitud_empleado"},visible=false, filterable=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechasolicitud", type="date", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la fecha de solicitud")
     * @Assert\DateTime()
     * @GRID\Column(type="date",title="Fecha Solicitud",groups={"solEmpleado","solicitud_empleado"},filter="input", align="center", inputType="datetime", format="Y-m-d",operators={"gte", "eq", "lte"}, defaultOperator="gte"))
     */
    private $fechasolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="aprobacionsolicitud", type="string", length=1 ,nullable=false)
     * @GRID\Column(groups={"solEmpleado","solicitud_empleado"},align="center", title="Estado", filterable=false)
     */
    private $aprobacionsolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="motivosolicitud", type="string", length=500, nullable=true)
     * @Assert\NotNull(message="Debe ingresar la aprobacion de solicitud")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "El motivo de solicitud no debe exceder los {{limit}} caracteres"
     * )
     */
    private $motivosolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="comentariosolicitud", type="string", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "El comentario de la solicitud no debe exceder los {{limit}} caracteres"
     * )
     */
    private $comentariosolicitud;

    /**
     * @var \Capacitacion
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\CapacitacionBundle\Entity\Capacitacion", inversedBy="idsolicitudcapacitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcapacitacion", referencedColumnName="id")
     * })
     * @GRID\Column(align="center",field="idcapacitacion.tematica", groups={"solEmpleado"},type="text", title="Temática", joinType="inner",operatorsVisible=false, operators={"like"})
     */
    private $idcapacitacion;

    /**
     * @var \SIGESRHI\ExpedienteBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     * @GRID\Column(field="idempleado.idexpediente.idsolicitudempleo.nombrecompleto", groups={"solicitud_empleado"},type="text", title="Empleado", joinType="inner", filterable=false)
     */
    private $idempleado;

    /*Agregar solo ORM*/
    //private $idjefe;



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
     * Set fechasolicitud
     *
     * @param \DateTime $fechasolicitud
     * @return Solicitudcapacitacion
     */
    public function setFechasolicitud($fechasolicitud)
    {
        $this->fechasolicitud = $fechasolicitud;
    
        return $this;
    }

    /**
     * Get fechasolicitud
     *
     * @return \DateTime 
     */
    public function getFechasolicitud()
    {
        return $this->fechasolicitud;
    }

    /**
     * Set aprobacionsolicitud
     *
     * @param integer $aprobacionsolicitud
     * @return Solicitudcapacitacion
     */
    public function setAprobacionsolicitud($aprobacionsolicitud)
    {
        $this->aprobacionsolicitud = $aprobacionsolicitud;
    
        return $this;
    }

    /**
     * Get aprobacionsolicitud
     *
     * @return integer 
     */
    public function getAprobacionsolicitud()
    {
        return $this->aprobacionsolicitud;
    }

    /**
     * Set motivosolicitud
     *
     * @param string $motivosolicitud
     * @return Solicitudcapacitacion
     */
    public function setMotivosolicitud($motivosolicitud)
    {
        $this->motivosolicitud = $motivosolicitud;
    
        return $this;
    }

    /**
     * Get motivosolicitud
     *
     * @return string 
     */
    public function getMotivosolicitud()
    {
        return $this->motivosolicitud;
    }

    /**
     * Set comentariosolicitud
     *
     * @param string $comentariosolicitud
     * @return Solicitudcapacitacion
     */
    public function setComentariosolicitud($comentariosolicitud)
    {
        $this->comentariosolicitud = $comentariosolicitud;
    
        return $this;
    }

    /**
     * Get comentariosolicitud
     *
     * @return string 
     */
    public function getComentariosolicitud()
    {
        return $this->comentariosolicitud;
    }

    /**
     * Set idcapacitacion
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion
     * @return Solicitudcapacitacion
     */
    public function setIdcapacitacion(\SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion = null)
    {
        $this->idcapacitacion = $idcapacitacion;
    
        return $this;
    }

    /**
     * Get idcapacitacion
     *
     * @return \SIGESRHI\CapacitacionBundle\Entity\Capacitacion 
     */
    public function getIdcapacitacion()
    {
        return $this->idcapacitacion;
    }

    /**
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Solicitudcapacitacion
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
     * Set idjefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe
     * @return Solicitudcapacitacion
     */
    public function setIdjefe(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe = null)
    {
        $this->idjefe = $idjefe;
    
        return $this;
    }

    /**
     * Get idjefe
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdjefe()
    {
        return $this->idjefe;
    }
}