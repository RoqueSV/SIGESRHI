<?php

namespace SIGESRHI\CapacitacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Institucioncapacitadora
 *
 * @ORM\Table(name="institucioncapacitadora")
 * @ORM\Entity
 * @GRID\Source(columns="id,nombreinstitucion,nombrecontacto,telefonocontacto", groups={"grupo_institucion"})
 */
class Institucioncapacitadora
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="institucioncapacitadora_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_institucion"}, visible=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreinstitucion", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la institucion")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre de la institucion no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=true, groups={"grupo_institucion"}, title="Nombre", operators={"like"},operatorsVisible=false)
     */
    private $nombreinstitucion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecontacto", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del contacto")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del contacto no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups={"grupo_institucion"}, title="Contacto")
     */
    private $nombrecontacto;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonocontacto", type="string", length=8, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono de contacto")
     * @GRID\Column(filterable=false, groups={"grupo_institucion"}, title="Teléfono", align="center")
     */
    private $telefonocontacto;

    /**
     * @var string
     *
     * @ORM\Column(name="cargocontacto", type="string", length=75, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el cargo")
     * @Assert\Length(
     * max = "75",
     * maxMessage = "El cargo no debe exceder los {{limit}} caracteres"
     * )
     */
    private $cargocontacto;

    /**
     * @var string
     *
     * @ORM\Column(name="emailcontacto", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el correo")
     * @Assert\Email(
     *     message = "El correo '{{ value }}' no es valido."
     * )
     */
    private $emailcontacto;

    /**
     * @ORM\OneToMany(targetEntity="Capacitador", mappedBy="idinstitucion")
     */
    private $idcapacitador;

    public function __toString(){
        return $this->getNombreinstitucion();
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
     * Set nombreinstitucion
     *
     * @param string $nombreinstitucion
     * @return Institucioncapacitadora
     */
    public function setNombreinstitucion($nombreinstitucion)
    {
        $this->nombreinstitucion = $nombreinstitucion;
    
        return $this;
    }

    /**
     * Get nombreinstitucion
     *
     * @return string 
     */
    public function getNombreinstitucion()
    {
        return $this->nombreinstitucion;
    }

    /**
     * Set nombrecontacto
     *
     * @param string $nombrecontacto
     * @return Institucioncapacitadora
     */
    public function setNombrecontacto($nombrecontacto)
    {
        $this->nombrecontacto = $nombrecontacto;
    
        return $this;
    }

    /**
     * Get nombrecontacto
     *
     * @return string 
     */
    public function getNombrecontacto()
    {
        return $this->nombrecontacto;
    }

    /**
     * Set telefonocontacto
     *
     * @param string $telefonocontacto
     * @return Institucioncapacitadora
     */
    public function setTelefonocontacto($telefonocontacto)
    {
        $this->telefonocontacto = $telefonocontacto;
    
        return $this;
    }

    /**
     * Get telefonocontacto
     *
     * @return string 
     */
    public function getTelefonocontacto()
    {
        return $this->telefonocontacto;
    }

    /**
     * Set cargocontacto
     *
     * @param string $cargocontacto
     * @return Institucioncapacitadora
     */
    public function setCargocontacto($cargocontacto)
    {
        $this->cargocontacto = $cargocontacto;
    
        return $this;
    }

    /**
     * Get cargocontacto
     *
     * @return string 
     */
    public function getCargocontacto()
    {
        return $this->cargocontacto;
    }

    /**
     * Set emailcontacto
     *
     * @param string $emailcontacto
     * @return Institucioncapacitadora
     */
    public function setEmailcontacto($emailcontacto)
    {
        $this->emailcontacto = $emailcontacto;
    
        return $this;
    }

    /**
     * Get emailcontacto
     *
     * @return string 
     */
    public function getEmailcontacto()
    {
        return $this->emailcontacto;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcapacitador = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idcapacitador
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador
     * @return Institucioncapacitadora
     */
    public function addIdcapacitador(\SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador)
    {
        $this->idcapacitador[] = $idcapacitador;
    
        return $this;
    }

    /**
     * Remove idcapacitador
     *
     * @param \SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador
     */
    public function removeIdcapacitador(\SIGESRHI\CapacitacionBundle\Entity\Capacitador $idcapacitador)
    {
        $this->idcapacitador->removeElement($idcapacitador);
    }

    /**
     * Get idcapacitador
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcapacitador()
    {
        return $this->idcapacitador;
    }
}