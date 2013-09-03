<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitudempleo
 *
 * @ORM\Table(name="solicitudempleo")
 * @ORM\Entity
 */
class Solicitudempleo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="solicitudempleo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numsolicitud", type="integer", nullable=true)
     */
    private $numsolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidocasada", type="string", length=20, nullable=true)
     */
    private $apellidocasada;

    /**
     * @var string
     *
     * @ORM\Column(name="primerapellido", type="string", length=20, nullable=false)
     */
    private $primerapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoapellido", type="string", length=20, nullable=false)
     */
    private $segundoapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=25, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="colonia", type="string", length=30, nullable=false)
     */
    private $colonia;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=30, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocivil", type="string", length=12, nullable=false)
     */
    private $estadocivil;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonofijo", type="string", nullable=false)
     */
    private $telefonofijo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonomovil", type="string", nullable=false)
     */
    private $telefonomovil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarnac", type="string", length=25, nullable=false)
     */
    private $lugarnac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fehanac", type="date", nullable=false)
     */
    private $fehanac;

    /**
     * @var string
     *
     * @ORM\Column(name="dui", type="string", nullable=false)
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="lugardui", type="string", length=50, nullable=false)
     */
    private $lugardui;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadui", type="date", nullable=false)
     */
    private $fechadui;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="isss", type="string", nullable=true)
     */
    private $isss;

    /**
     * @var string
     *
     * @ORM\Column(name="nup", type="string", nullable=true)
     */
    private $nup;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=20, nullable=true)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", nullable=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="fotografia", type="string", length=50, nullable=false)
     */
    private $fotografia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistro", type="date", nullable=false)
     */
    private $fecharegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechamodificacion", type="date", nullable=true)
     */
    private $fechamodificacion;

    /**
     * @var \Municipio
     *
     * @ORM\ManyToOne(targetEntity="Municipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmunicipio", referencedColumnName="id")
     * })
     */
    private $idmunicipio;

    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     * })
     */
    private $idplaza;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
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
     * Set numsolicitud
     *
     * @param integer $numsolicitud
     * @return Solicitudempleo
     */
    public function setNumsolicitud($numsolicitud)
    {
        $this->numsolicitud = $numsolicitud;
    
        return $this;
    }

    /**
     * Get numsolicitud
     *
     * @return integer 
     */
    public function getNumsolicitud()
    {
        return $this->numsolicitud;
    }

    /**
     * Set apellidocasada
     *
     * @param string $apellidocasada
     * @return Solicitudempleo
     */
    public function setApellidocasada($apellidocasada)
    {
        $this->apellidocasada = $apellidocasada;
    
        return $this;
    }

    /**
     * Get apellidocasada
     *
     * @return string 
     */
    public function getApellidocasada()
    {
        return $this->apellidocasada;
    }

    /**
     * Set primerapellido
     *
     * @param string $primerapellido
     * @return Solicitudempleo
     */
    public function setPrimerapellido($primerapellido)
    {
        $this->primerapellido = $primerapellido;
    
        return $this;
    }

    /**
     * Get primerapellido
     *
     * @return string 
     */
    public function getPrimerapellido()
    {
        return $this->primerapellido;
    }

    /**
     * Set segundoapellido
     *
     * @param string $segundoapellido
     * @return Solicitudempleo
     */
    public function setSegundoapellido($segundoapellido)
    {
        $this->segundoapellido = $segundoapellido;
    
        return $this;
    }

    /**
     * Get segundoapellido
     *
     * @return string 
     */
    public function getSegundoapellido()
    {
        return $this->segundoapellido;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Solicitudempleo
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    
        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     * @return Solicitudempleo
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;
    
        return $this;
    }

    /**
     * Get colonia
     *
     * @return string 
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Solicitudempleo
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;
    
        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set estadocivil
     *
     * @param string $estadocivil
     * @return Solicitudempleo
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;
    
        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return string 
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set telefonofijo
     *
     * @param string $telefonofijo
     * @return Solicitudempleo
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;
    
        return $this;
    }

    /**
     * Get telefonofijo
     *
     * @return string 
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set telefonomovil
     *
     * @param string $telefonomovil
     * @return Solicitudempleo
     */
    public function setTelefonomovil($telefonomovil)
    {
        $this->telefonomovil = $telefonomovil;
    
        return $this;
    }

    /**
     * Get telefonomovil
     *
     * @return string 
     */
    public function getTelefonomovil()
    {
        return $this->telefonomovil;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Solicitudempleo
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lugarnac
     *
     * @param string $lugarnac
     * @return Solicitudempleo
     */
    public function setLugarnac($lugarnac)
    {
        $this->lugarnac = $lugarnac;
    
        return $this;
    }

    /**
     * Get lugarnac
     *
     * @return string 
     */
    public function getLugarnac()
    {
        return $this->lugarnac;
    }

    /**
     * Set fehanac
     *
     * @param \DateTime $fehanac
     * @return Solicitudempleo
     */
    public function setFehanac($fehanac)
    {
        $this->fehanac = $fehanac;
    
        return $this;
    }

    /**
     * Get fehanac
     *
     * @return \DateTime 
     */
    public function getFehanac()
    {
        return $this->fehanac;
    }

    /**
     * Set dui
     *
     * @param string $dui
     * @return Solicitudempleo
     */
    public function setDui($dui)
    {
        $this->dui = $dui;
    
        return $this;
    }

    /**
     * Get dui
     *
     * @return string 
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set lugardui
     *
     * @param string $lugardui
     * @return Solicitudempleo
     */
    public function setLugardui($lugardui)
    {
        $this->lugardui = $lugardui;
    
        return $this;
    }

    /**
     * Get lugardui
     *
     * @return string 
     */
    public function getLugardui()
    {
        return $this->lugardui;
    }

    /**
     * Set fechadui
     *
     * @param \DateTime $fechadui
     * @return Solicitudempleo
     */
    public function setFechadui($fechadui)
    {
        $this->fechadui = $fechadui;
    
        return $this;
    }

    /**
     * Get fechadui
     *
     * @return \DateTime 
     */
    public function getFechadui()
    {
        return $this->fechadui;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Solicitudempleo
     */
    public function setNit($nit)
    {
        $this->nit = $nit;
    
        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set isss
     *
     * @param string $isss
     * @return Solicitudempleo
     */
    public function setIsss($isss)
    {
        $this->isss = $isss;
    
        return $this;
    }

    /**
     * Get isss
     *
     * @return string 
     */
    public function getIsss()
    {
        return $this->isss;
    }

    /**
     * Set nup
     *
     * @param string $nup
     * @return Solicitudempleo
     */
    public function setNup($nup)
    {
        $this->nup = $nup;
    
        return $this;
    }

    /**
     * Get nup
     *
     * @return string 
     */
    public function getNup()
    {
        return $this->nup;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Solicitudempleo
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
    
        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Solicitudempleo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set fotografia
     *
     * @param string $fotografia
     * @return Solicitudempleo
     */
    public function setFotografia($fotografia)
    {
        $this->fotografia = $fotografia;
    
        return $this;
    }

    /**
     * Get fotografia
     *
     * @return string 
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return Solicitudempleo
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;
    
        return $this;
    }

    /**
     * Get fecharegistro
     *
     * @return \DateTime 
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /**
     * Set fechamodificacion
     *
     * @param \DateTime $fechamodificacion
     * @return Solicitudempleo
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;
    
        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return \DateTime 
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set idmunicipio
     *
     * @param \SIGESRHI\AdminBundle\Entity\Municipio $idmunicipio
     * @return Solicitudempleo
     */
    public function setIdmunicipio(\SIGESRHI\AdminBundle\Entity\Municipio $idmunicipio = null)
    {
        $this->idmunicipio = $idmunicipio;
    
        return $this;
    }

    /**
     * Get idmunicipio
     *
     * @return \SIGESRHI\AdminBundle\Entity\Municipio 
     */
    public function getIdmunicipio()
    {
        return $this->idmunicipio;
    }

    /**
     * Set idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Solicitudempleo
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

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\AdminBundle\Entity\Expediente $idexpediente
     * @return Solicitudempleo
     */
    public function setIdexpediente(\SIGESRHI\AdminBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\AdminBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }
}