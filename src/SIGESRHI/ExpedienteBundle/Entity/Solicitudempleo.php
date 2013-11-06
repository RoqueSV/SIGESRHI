<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Solicitudempleo
 *
 * @ORM\Table(name="solicitudempleo")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Repositorio\SolicitudempleoRepository")
 * @ORM\HasLifecycleCallbacks
 * @Assert\Callback(methods={"esDuiValido"})
 * @Assert\Callback(methods={"esNitValido"})
 * @Vich\Uploadable
 *
 * @GRID\Source(columns="id,nombres, primerapellido, segundoapellido,idplaza.nombreplaza,idexpediente.tipoexpediente,idexpediente.id,idexpediente.idpruebapsicologica.id",groups={"grupo_pruebapsicologica"})
 * @GRID\Source(columns="id,numsolicitud, nombres, primerapellido, segundoapellido, apellidocasada, idexpediente.tipoexpediente,idplaza.nombreplaza",groups={"solicitud_empleo"})
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica","solicitud_empleo"}, visible=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numsolicitud", type="integer", nullable=true)
     * @Assert\NotNull(message="Debe ingresar el numero de solicitud")
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     * @GRID\Column(filterable=false, title="Num. Solicitud", groups={"solicitud_empleo"}, visible=true)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     * @GRID\Column(filterable=false, groups={"solicitud_empleo"}, visible=false)
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
     *
     * @GRID\Column(title="Apellido", filterable=false, groups={"grupo_pruebapsicologica","apellidos", "solicitud_empleo"}, operators={"like","eq"},visible=false)
     */
    private $primerapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoapellido", type="string", length=20, nullable=true)
     * @Assert\Length(
     * max = "20",
     * maxMessage = "El segundo apellido no debe exceder los {{limit}} caracteres"
     * )
     *
     * @GRID\Column(title="Apellido", filterable=false, type="text", groups={"grupo_pruebapsicologica","apellidos", "solicitud_empleo"}, operators={"like","eq"},visible=false)
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
     *
     * @GRID\Column(title="Nombre", filter="input", groups={"grupo_pruebapsicologica", "solicitud_empleo"}, type="text", operators={"like","eq"})
     *
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrecompleto", type="string", length=100, nullable=true)
     *
     */
    private $nombrecompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="colonia", type="string", length=30, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la colonia")
     * @Assert\Length(
     * max = "30",
     * maxMessage = "La colonia no debe exceder los {{limit}} caracteres"
     * )
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $lugarnac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanac", type="date", nullable=false)
     * 
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $lugardui;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadui", type="date", nullable=false)
     **
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)     
      */
    private $fechadui;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=14, nullable=false)
     * @Assert\Length(
     * max = "14",
     * maxMessage = "El NIT no debe exceder los {{limit}} caracteres"
     *)
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", nullable=false)
     * @Assert\NotNull(message="Debe seleccionar el sexo")
     *
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="fotografia", type="string", length=100, nullable=false)
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre o ruta de la fotografia no debe exceder los {{limit}} caracteres"
     * )
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $fotografia;

    
    /**
     * @Assert\File(
     * maxSize="2048k",
     * mimeTypes = {"image/jpeg", "image/png"},
     * maxSizeMessage = "El tamaño maximo permitido para la fotografia es 2MB.",
     * mimeTypesMessage = "Por favor suba una fotografía valida (formato jpeg o png)."
     * )
     *
     * @Vich\UploadableField(mapping="fotografias", fileNameProperty="fotografia")
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $file;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistro", type="date", nullable=false)
     * 
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $fecharegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechamodificacion", type="date", nullable=false)
     * 
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
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
     *
     * @GRID\Column(filterable=false, groups={"grupo_pruebapsicologica"}, visible=false)
     */
    private $dependenciaparinst;

   private $aceptar;


    public function setAceptar($aceptar){
 
    $this->aceptar = $aceptar;
    
        return $this;
   }

   public function getAceptar(){
    return $this->aceptar;
   }

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


     public function __toString() {
        return $this->getNombres();
    } 


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
     *
     * @GRID\Column(field="idplaza.nombreplaza", title="Puesto al que aplica", joinType="inner", filterable=false)
     */
    private $idplaza;

    /**
     * @var \Expediente
     *
     * @ORM\OneToOne(targetEntity="Expediente", inversedBy="idsolicitudempleo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     *
     * @GRID\Column(primary=true, field="idexpediente.id", title="Idexpediente", joinType="inner",visible=false, filterable=false)
     * @GRID\Column(field="idexpediente.tipoexpediente", title="Estado", joinType="inner", filterable=false)
     * @GRID\Column(field="idexpediente.idpruebapsicologica.id", title="Prueba", filterable=false,visible=false, groups={"grupo_pruebapsicologica"})
     * @GRID\Column(field="idexpediente.tipoexpediente", joinType="inner", filterable=false, groups={"solicitud_empleo"}, visible=false)
     */
    private $idexpediente;



    /****************************************************************/
    //Pruebas de integracion de coleccion de formularios

       

    public function __construct()
    {
        $this->Dempleos = new ArrayCollection();
        $this->Dfamiliares = new ArrayCollection();
        $this->Destudios = new ArrayCollection();
        $this->Idiomas = new ArrayCollection();
    }


 /*************Datos de empleos****************/

    /**
     * @ORM\OneToMany(targetEntity="Datosempleo", mappedBy="idsolicitudempleo", cascade={"persist","remove"})
     *@Assert\Valid
     */
    protected $Dempleos;


    /**
     * Get Dempleos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
     public function getDempleos()
    {
        return $this->Dempleos;
    }

    public function setDempleos(\Doctrine\Common\Collections\Collection $dempleos)
    {
        $this->Dempleos = $dempleos;
        foreach ($dempleos as $empleo) {
            $empleo->setIdsolicitudempleo($this);
        }
    }


    /*********Datos Familiares*****************/
    
    /**
     * @ORM\OneToMany(targetEntity="Datosfamiliares", mappedBy="idsolicitudempleo", cascade={"persist","remove"})
     * @Assert\Valid
     */
    protected $Dfamiliares;

   /**
     * Get Dfamiliares
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDfamiliares()
    {
        return $this->Dfamiliares;
    }

  
    public function setDfamiliares(\Doctrine\Common\Collections\Collection $dfamiliares)
    {
        $this->Dfamiliares = $dfamiliares;
        foreach ($dfamiliares as $familiar) {
            $familiar->setIdsolicitudempleo($this);
        }
    }


    /****************Datos de estudio *************************/

    /**
     * @ORM\OneToMany(targetEntity="Informacionacademica", mappedBy="idsolicitudempleo", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Destudios;

    /**
     * Get Destudios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDestudios()
    {
        return $this->Destudios;
    }

    public function setDestudios(\Doctrine\Common\Collections\Collection $destudios)
    {
        $this->Destudios = $destudios;
        foreach ($destudios as $estudio) {
            $estudio->setIdsolicitudempleo($this);
        }
    }


    /************************* Idiomas ***************************/



    /**
     * @ORM\OneToMany(targetEntity="Idioma", mappedBy="idsolicitudempleo", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $Idiomas;

    /**
     * Get Idiomas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdiomas()
    {
        return $this->Idiomas;
    }

    public function setIdiomas(\Doctrine\Common\Collections\Collection $idiomas)
    {
        $this->Idiomas = $idiomas;
        foreach ($idiomas as $idioma) {
            $idioma->setIdsolicitudempleo($this);
        }
    }


    /*****************************************************************/


    /******************** Validacion del dui y nit ******************/


    
        public function esDuiValido(ExecutionContextInterface $context)
            {
           
            $pDui = $this->getDui();


        $i= 0;
        $suma = 0;
        $digito = 0;

        if($pDui == '000000000'||$pDui=='' || strlen($pDui) != 9){

            $context->addViolationAt('dui', 'El DUI introducido no tiene
                el formato correcto (9 digitos), sin guiones y
                sin dejar ningún espacio en blanco)', array(), null);
                return;

        }
                

        $digito = substr($pDui,8);

        for($i=1;$i<strlen($pDui);$i++){
                $suma = $suma + ((substr($pDui,$i-1,1))*(10-$i));
                //echo "$suma<br>";
        }//fin for

        $validar = 0;
        $validar = (10-($suma%10)) % 10;
        //echo "<br><br>".$validar."==".$digito."<br><br>";
       
        if($digito != $validar){

            $context->addViolationAt('dui', 'DUI ingresado Inválido.',array(), null);

        }//fin if

    
            }//fin funcion esDuiValido()



    //Funcion validar NIT

            
            public function esNitValido(ExecutionContextInterface $context){

                $nit= $this->getNit();

    if(preg_match('/(^\d{14})/',$nit)){
        $verificador = (int) substr($nit,13,1);
        $valida = false;
        $suma = 0;
        if(( (int)substr($nit,10,3) ) <= 100){
            for($i = 1; $i <= 13; $i++){
                $suma += ( (int) substr($nit,( $i - 1 ),1) ) * ( 15 - $i );
            }
            $valida = ($suma%11);

            if($valida == 10){
                $valida = 0;
            }
        }else{
            for($i = 1; $i <= 13; $i++){
                $factor = (3 + (6 * floor(abs(( $i + 4 ) / 6)))) - $i;
                $suma += ( (int) substr($nit,( $i - 1 ),1) ) * $factor;
            }
            $mod = ($suma%11);
            if($mod > 1){
                $valida = 11 - $mod;
            }else{
                $valida = 0;
            }
        }
        if($valida != $verificador) 
             $context->addViolationAt('nit', 'El NIT introducido no es válido.', array(), null);
            
   }
   else{
    $context->addViolationAt('nit', 'NIT no tiene el formato correcto (14 digitos), sin guiones y
                sin dejar ningún espacio en blanco)', array(), null);
    }

}//fin validar NIT








    /****************************************************************/








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
     * Set nombrecompleto
     *
     * @param string $nombrecompleto
     * @return Solicitudempleo
     */
    public function setNombrecompleto($nombrecompleto)
    {
        $this->nombrecompleto = $nombrecompleto;
    
        return $this;
    }

    /**
     * Get nombrecompleto
     *
     * @return string 
     */
    public function getNombrecompleto()
    {
        return $this->nombrecompleto;
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
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }



}//fin class