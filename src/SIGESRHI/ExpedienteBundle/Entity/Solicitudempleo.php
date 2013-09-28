<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Solicitudempleo
 *
 * @ORM\Table(name="solicitudempleo")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Entity\SolicitudempleoRepository")
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
     * @Assert\NotNull(message="Debe ingresar el numero de solicitud")
     */
    private $numsolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidocasada", type="string", length=20, nullable=true)
     * @Assert\Length(
     * max = "20",
     * maxMessage = "El apellido de casada no debe exceder los {{limit}} caracteres"
     * )
     */
    private $apellidocasada;

    /**
     * @var string
     *
     * @ORM\Column(name="primerapellido", type="string", length=20, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el primer apellido")
     * @Assert\Length(
     * max = "20",
     * maxMessage = "El primer apellido no debe exceder los {{limit}} caracteres"
     * )
     */
    private $primerapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoapellido", type="string", length=20, nullable=false)
     * @Assert\Length(
     * max = "20",
     * maxMessage = "El segundo apellido no debe exceder los {{limit}} caracteres"
     * )
     */
    private $segundoapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar los nombres")
     * @Assert\Length(
     * max = "25",
     * maxMessage = "El nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="colonia", type="string", length=30, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la colonia")
     * @Assert\Length(
     * max = "30",
     * maxMessage = "La colonia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $colonia;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=30, nullable=true)
     * @Assert\Length(
     * max = "30",
     * maxMessage = "La calle no debe exceder los {{limit}} caracteres"
     * )
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocivil", type="string", length=12, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado civil")
     * @Assert\Length(
     * max = "12",
     * maxMessage = "El estado civil no debe exceder los {{limit}} caracteres"
     * )
     */
    private $estadocivil;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonofijo", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono")
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El telefono no debe exceder los {{limit}} caracteres"
     * )
     */
    private $telefonofijo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonomovil", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el telefono movil")
     * @Assert\Length(
     * max = "8",
     * maxMessage = "El telefono movil no debe exceder los {{limit}} caracteres"
     * )
     */
    private $telefonomovil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el correo")
     * @Assert\Email(
     *     message = "El correo '{{ value }}' no es un correo valido."
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarnac", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el lugar de nacimiento")
     * @Assert\Length(
     * max = "25",
     * maxMessage = "El lugar de nacimiento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lugarnac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanac", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de nacimiento")
     */
    private $fechanac;

    /**
     * @var string
     *
     * @ORM\Column(name="dui", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el DUI")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El DUI no debe exceder los {{limit}} caracteres"
     * )
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="lugardui", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el lugar de emision del DUI")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El lugar de emision del DUI no debe exceder los {{limit}} caracteres"
     * )
     */
    private $lugardui;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadui", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de emision del DUI")
     */
    private $fechadui;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=14, nullable=true)
     * @Assert\Length(
     * max = "14",
     * maxMessage = "El NIT no debe exceder los {{limit}} caracteres"
     *)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="isss", type="string", length=9, nullable=true)
     * @Assert\Length(
     * max = "9",
     * maxMessage = "El N° ISSS no debe exceder los {{limit}} caracteres"
     *)
     */
    private $isss;

    /**
     * @var string
     *
     * @ORM\Column(name="nup", type="string", length=12, nullable=true)
     * @Assert\Length(
     * max = "12",
     * maxMessage = "El NUP no debe exceder los {{limit}} caracteres"
     *)
     */
    private $nup;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=7, nullable=true)
     * @Assert\Length(
     * max = "7",
     * maxMessage = "El NIP no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", nullable=false)
     * @Assert\NotNull(message="Debe seleccionar el sexo")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="fotografia", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe cargar una fotografia")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre o ruta de la fotografia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $fotografia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistro", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de registro")
     */
    private $fecharegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechamodificacion", type="date", nullable=false)
     * @Assert\DateTime()
     */
    private $fechamodificacion;




    /************************datos de pariente laborando dentro del ISRI************************/

    /**
     * @var string
     *
     * @ORM\Column(name="nombreparinst", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El Nombre no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreparinst;


    /**
     * @var string
     *
     * @ORM\Column(name="parentescoparinst", type="string", length=50, nullable=true)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El Parentesco no debe exceder los {{limit}} caracteres"
     * )
     */
    private $parentescoparinst;


    /**
     * @var string
     *
     * @ORM\Column(name="dependenciaparinst", type="string", length=75, nullable=true)
     * @Assert\Length(
     * max = "75",
     * maxMessage = "la dependencia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $dependenciaparinst;



                /***************** Funciones set y get ***********************/

    /**
     * Set nombreparinst
     *
     * @param string $nombreparinst
     * @return Solicitudempleo
     */
    public function setNombreparinst($nombreparinst)
    {
        $this->nombreparinst = $nombreparinst;
    
        return $this;
    }

    
    /**
     * Get nombreparinst
     *
     * @return string 
     */
    public function getNombreparinst()
    {
        return $this->nombreparinst;
    }


    /**
     * Set parentescoparinst
     *
     * @param string $parentescoparinst
     * @return Solicitudempleo
     */
    public function setParentescoparinst($parentescoparinst)
    {
        $this->parentescoparinst = $parentescoparinst;
    
        return $this;
    }

    
    /**
     * Get parentescoparinst
     *
     * @return string 
     */
    public function getParentescoparinst()
    {
        return $this->parentescoparinst;
    }


    /**
     * Set dependenciaparinst
     *
     * @param string $dependenciaparinst
     * @return Solicitudempleo
     */
    public function setDependenciaparinst($dependenciaparinst)
    {
        $this->dependenciaparinst = $dependenciaparinst;
    
        return $this;
    }

    
    /**
     * Get dependenciaparinst
     *
     * @return string 
     */
    public function getDependenciaparinst()
    {
        return $this->dependenciaparinst;
    }


    /******************************************************************************************/





















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
     * @var \SIGESRHI\AdminBundle\Entity\\Plaza
     *
     * @ORM\ManyToOne(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza")
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



    /****************************************************************/
    //Pruebas de integracion de coleccion de formularios

        /*************Datos de empleos****************/

    /**
     * @ORM\OneToMany(targetEntity="Datosempleo", mappedBy="idsolicitudempleo")
     */
    protected $Dempleos;

    public function __construct()
    {
        $this->Dempleos = new ArrayCollection();
        $this->Dfamiliares = new ArrayCollection();
        $this->Destudios = new ArrayCollection();
        $this->Idiomas = new ArrayCollection();
    }


     public function getDempleos()
    {
        return $this->Dempleos;
    }

    public function setDempleos(ArrayCollection $Dempleos)
    {
        $this->Dempleos = $Dempleos;
    }


    /*********Datos Familiares*****************/
    
    /**
     * @ORM\OneToMany(targetEntity="Datosfamiliares", mappedBy="idsolicitudempleo")
     */
    protected $Dfamiliares;

    public function getDfamiliares()
    {
        return $this->Dfamiliares;
    }

    public function setDfamiliares(ArrayCollection $Dfamiliares)
    {
        $this->Dfamiliares = $Dfamiliares;
    }


    /****************Datos de estudio *************************/

    /**
     * @ORM\OneToMany(targetEntity="Informacionacademica", mappedBy="idsolicitudempleo")
     */
    protected $Destudios;

    public function getDestudios()
    {
        return $this->Destudios;
    }

    public function setDestudios(ArrayCollection $Destudios)
    {
        $this->Destudios = $Destudios;
    }


    /************************* Idiomas ***************************/



    /**
     * @ORM\OneToMany(targetEntity="Idioma", mappedBy="idsolicitudempleo")
     */
    protected $Idiomas;

    public function getIdiomas()
    {
        return $this->Idiomas;
    }

    public function setIdiomas(ArrayCollection $Idiomas)
    {
        $this->Idiomas = $Idiomas;
    }


    /*****************************************************************/




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
     * Set fechanac
     *
     * @param \DateTime $fechanac
     * @return Solicitudempleo
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;
    
        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime 
     */
    public function getFechanac()
    {
        return $this->fechanac;
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
     * @param \SIGESRHI\ExpedienteBundle\Entity\Municipio $idmunicipio
     * @return Solicitudempleo
     */
    public function setIdmunicipio(\SIGESRHI\ExpedienteBundle\Entity\Municipio $idmunicipio = null)
    {
        $this->idmunicipio = $idmunicipio;
    
        return $this;
    }

    /**
     * Get idmunicipio
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Municipio 
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
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Solicitudempleo
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
     * Add Dempleos
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Datosempleo $dempleos
     * @return Solicitudempleo
     */
    public function addDempleo(\SIGESRHI\ExpedienteBundle\Entity\Datosempleo $dempleos)
    {
        $this->Dempleos[] = $dempleos;
    
        return $this;
    }

    /**
     * Remove Dempleos
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Datosempleo $dempleos
     */
    public function removeDempleo(\SIGESRHI\ExpedienteBundle\Entity\Datosempleo $dempleos)
    {
        $this->Dempleos->removeElement($dempleos);
    }

    /**
     * Add Dfamiliares
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares $dfamiliares
     * @return Solicitudempleo
     */
    public function addDfamiliare(\SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares $dfamiliares)
    {
        $this->Dfamiliares[] = $dfamiliares;
    
        return $this;
    }

    /**
     * Remove Dfamiliares
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares $dfamiliares
     */
    public function removeDfamiliare(\SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares $dfamiliares)
    {
        $this->Dfamiliares->removeElement($dfamiliares);
    }

    /**
     * Add Destudios
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $destudios
     * @return Solicitudempleo
     */
    public function addDestudio(\SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $destudios)
    {
        $this->Destudios[] = $destudios;
    
        return $this;
    }

    /**
     * Remove Destudios
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $destudios
     */
    public function removeDestudio(\SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $destudios)
    {
        $this->Destudios->removeElement($destudios);
    }

    /**
     * Add Idiomas
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Idioma $idiomas
     * @return Solicitudempleo
     */
    public function addIdioma(\SIGESRHI\ExpedienteBundle\Entity\Idioma $idiomas)
    {
        $this->Idiomas[] = $idiomas;
    
        return $this;
    }

    /**
     * Remove Idiomas
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Idioma $idiomas
     */
    public function removeIdioma(\SIGESRHI\ExpedienteBundle\Entity\Idioma $idiomas)
    {
        $this->Idiomas->removeElement($idiomas);
    }
}