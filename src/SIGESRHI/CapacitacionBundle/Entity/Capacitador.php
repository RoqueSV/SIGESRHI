<?php

namespace SIGESRHI\CapacitacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Capacitador
 *
 * @ORM\Table(name="capacitador")
 * @ORM\Entity
 * @GRID\Source(columns="id,nombrecapacitador,telefonocapacitador,idinstitucion.nombreinstitucion", groups={"grupo_capacitador"})
 */
class Capacitador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="capacitador_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_capacitador"}, visible=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecapacitador", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del capacitador")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del capacitador no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=true, groups={"grupo_capacitador"}, title="Nombre", operators={"like"}, operatorsVisible=false)
     */
    private $nombrecapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonocapacitador", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono")
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El numero de telefono no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_capacitador"}, title="Teléfono", align="center")
     */
    private $telefonocapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="correocapacitador", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la correo")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El correo del capacitador no debe exceder los {{limit}} caracteres"
     * )
     * @Assert\Email(
     *     message = "El correo del capacitador '{{ value }}' no es un correo valido."
     * )
     */
    private $correocapacitador;

    /**
     * @var string
     *
     * @ORM\Column(name="tematicacapacitador", type="string", length=250, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la tematica")
     * @Assert\Length(
     * max = "250",
     * maxMessage = "La tematica del capacitador no debe exceder los {{limit}} caracteres"
     * )
     */
    private $tematicacapacitador;

    /**
     * @var \Institucioncapacitadora
     *
     * @ORM\ManyToOne(targetEntity="Institucioncapacitadora", inversedBy="idcapacitador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idinstitucion", referencedColumnName="id")
     * })
     * @GRID\Column(field="idinstitucion.nombreinstitucion", groups="grupo_capacitador", type="text", title="Institución", joinType="inner", filterable=false) 
     */
    private $idinstitucion;

    /**
     * @ORM\OneToMany(targetEntity="Capacitacion", mappedBy="idcapacitador")
     */
    private $idcapacitacion;

    public function __toString(){
        return $this->getNombrecapacitador();
    }

    public function capacitadorins(){
        return $this->getNombrecapacitador()." (".$this->getIdinstitucion()->getNombreinstitucion().")";
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
     * Set nombrecapacitador
     *
     * @param string $nombrecapacitador
     * @return Capacitador
     */
    public function setNombrecapacitador($nombrecapacitador)
    {
        $this->nombrecapacitador = $nombrecapacitador;
    
        return $this;
    }

    /**
     * Get nombrecapacitador
     *
     * @return string 
     */
    public function getNombrecapacitador()
    {
        return $this->nombrecapacitador;
    }

    /**
     * Set telefonocapacitador
     *
     * @param string $telefonocapacitador
     * @return Capacitador
     */
    public function setTelefonocapacitador($telefonocapacitador)
    {
        $this->telefonocapacitador = $telefonocapacitador;
    
        return $this;
    }

    /**
     * Get telefonocapacitador
     *
     * @return string 
     */
    public function getTelefonocapacitador()
    {
        return $this->telefonocapacitador;
    }

    /**
     * Set correocapacitador
     *
     * @param string $correocapacitador
     * @return Capacitador
     */
    public function setCorreocapacitador($correocapacitador)
    {
        $this->correocapacitador = $correocapacitador;
    
        return $this;
    }

    /**
     * Get correocapacitador
     *
     * @return string 
     */
    public function getCorreocapacitador()
    {
        return $this->correocapacitador;
    }

    /**
     * Set tematicacapacitador
     *
     * @param string $tematicacapacitador
     * @return Capacitador
     */
    public function setTematicacapacitador($tematicacapacitador)
    {
        $this->tematicacapacitador = $tematicacapacitador;
    
        return $this;
    }

    /**
     * Get tematicacapacitador
     *
     * @return string 
     */
    public function getTematicacapacitador()
    {
        return $this->tematicacapacitador;
    }

    /**
     * Set idinstitucion
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora $idinstitucion
     * @return Capacitador
     */
    public function setIdinstitucion(\SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora $idinstitucion = null)
    {
        $this->idinstitucion = $idinstitucion;
    
        return $this;
    }

    /**
     * Get idinstitucion
     *
     * @return \SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora 
     */
    public function getIdinstitucion()
    {
        return $this->idinstitucion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcapacitacion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idcapacitacion
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion
     * @return Capacitador
     */
    public function addIdcapacitacion(\SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion)
    {
        $this->idcapacitacion[] = $idcapacitacion;
    
        return $this;
    }

    /**
     * Remove idcapacitacion
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion
     */
    public function removeIdcapacitacion(\SIGESRHI\CapacitacionBundle\Entity\Capacitacion $idcapacitacion)
    {
        $this->idcapacitacion->removeElement($idcapacitacion);
    }

    /**
     * Get idcapacitacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcapacitacion()
    {
        return $this->idcapacitacion;
    }
}