<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Plaza
 *
 * @ORM\Table(name="plaza")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Plaza
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="plaza_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreplaza", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la PLaza")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre de la plaza no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreplaza;


     public function __toString() {
        return $this->getNombreplaza();
    }



    /**
     * @var string
     *
     * @ORM\Column(name="descripcionplaza", type="string", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion de la plaza")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La descripcion de la plaza no debe exceder los {{limit}} caracteres"
     * )
     */
    private $descripcionplaza;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=true)
     * 
     */
    private $edad;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="experiencia", type="integer", nullable=true)
     * @Assert\NotNull(message="Debe ingresar una cantidad para la experiencia requerida")
     */
    private $experiencia;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sexo", type="string", nullable=true)
     *
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoplaza", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado de la plaza")
     */
    private $estadoplaza;

     /**
     * @var \Area
     *
     * @ORM\ManyToOne(targetEntity="Area",  inversedBy="idplaza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idarea", referencedColumnName="id")
     * })
     */
    private $idarea;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\SIGESRHI\ExpedienteBundle\Entity\Titulo", inversedBy="idplaza")
     * @ORM\JoinTable(name="tituloplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idtitulo", referencedColumnName="id")
     *   }
     * )
     */
    private $idtitulo;

    /**
     * @ORM\OneToMany(targetEntity="SIGESRHI\ExpedienteBundle\Entity\Contratacion", mappedBy="idplaza")
     */
    private $idcontratacion;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Conocimiento", inversedBy="idplaza")
     * @ORM\JoinTable(name="conocimientoplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idconocimiento", referencedColumnName="id")
     *   }
     * )
     */

    private $idconocimiento;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Funcion", inversedBy="idplaza")
     * @ORM\JoinTable(name="funcionplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idfuncion", referencedColumnName="id")
     *   }
     * )
     */
    private $idfuncion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Habilidad", inversedBy="idplaza")
     * @ORM\JoinTable(name="habilidadplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idhabilidad", referencedColumnName="id")
     *   }
     * )
     */
    private $idhabilidad;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Manejoequipo", inversedBy="idplaza")
     * @ORM\JoinTable(name="manejoequipoplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idmanejoequipo", referencedColumnName="id")
     *   }
     * )
     */
    private $idmanejoequipo;

    // ...
    /**
     * @ORM\OneToMany(targetEntity="Docautorizacionplaza", mappedBy="idplaza")
     */
    private $iddocautorizacion;
    

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable=true)
     */
    private $observaciones;
    
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;
    
        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updated;
    
    /**
     * @Assert\File(
     *     maxSize = "6000000",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "El archivo debe estar en formato pdf")
     */
    private $file;
    /**
     * Constructor
     */
    public function __construct()
    {
       
        $this->idconocimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idfuncion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idhabilidad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idmanejoequipo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idtitulo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcontratacion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Set nombreplaza
     *
     * @param string $nombreplaza
     * @return Plaza
     */
    public function setNombreplaza($nombreplaza)
    {
        $this->nombreplaza = $nombreplaza;
    
        return $this;
    }

    /**
     * Get nombreplaza
     *
     * @return string 
     */
    public function getNombreplaza()
    {
        return $this->nombreplaza;
    }

    /**
     * Set descripcionplaza
     *
     * @param string $descripcionplaza
     * @return Plaza
     */
    public function setDescripcionplaza($descripcionplaza)
    {
        $this->descripcionplaza = $descripcionplaza;
    
        return $this;
    }

    /**
     * Get descripcionplaza
     *
     * @return string 
     */
    public function getDescripcionplaza()
    {
        return $this->descripcionplaza;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Plaza
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    
        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set estadoplaza
     *
     * @param string $estadoplaza
     * @return Plaza
     */
    public function setEstadoplaza($estadoplaza)
    {
        $this->estadoplaza = $estadoplaza;
    
        return $this;
    }

    /**
     * Get estadoplaza
     *
     * @return string 
     */
    public function getEstadoplaza()
    {
        return $this->estadoplaza;
    }
    
    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Plaza
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    
     /**
     * Set idarea
     *
     * @param \SIGESRHI\AdminBundle\Entity\Area $idarea
     * @return Plaza
     */
    public function setIdarea(\SIGESRHI\AdminBundle\Entity\Area $idarea = null)
    {
        $this->idarea = $idarea;
    
        return $this;
    }

    /**
     * Get idarea
     *
     * @return \SIGESRHI\AdminBundle\Entity\Area
     */
    public function getIdarea()
    {
        return $this->idarea;
    }

    /**
     * Add idconocimiento
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento
     * @return Plaza
     */
    public function addIdconocimiento(\SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento)
    {
        $this->idconocimiento[] = $idconocimiento;
    
        return $this;
    }

    /**
     * Remove idconocimiento
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento
     */
    public function removeIdconocimiento(\SIGESRHI\AdminBundle\Entity\Conocimiento $idconocimiento)
    {
        $this->idconocimiento->removeElement($idconocimiento);
    }

    /**
     * Get idconocimiento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdconocimiento()
    {
        return $this->idconocimiento;
    }

    /**
     * Add idfuncion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Funcion $idfuncion
     * @return Plaza
     */
    public function addIdfuncion(\SIGESRHI\AdminBundle\Entity\Funcion $idfuncion)
    {
        $this->idfuncion[] = $idfuncion;
    
        return $this;
    }

    /**
     * Remove idfuncion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Funcion $idfuncion
     */
    public function removeIdfuncion(\SIGESRHI\AdminBundle\Entity\Funcion $idfuncion)
    {
        $this->idfuncion->removeElement($idfuncion);
    }

    /**
     * Get idfuncion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdfuncion()
    {
        return $this->idfuncion;
    }

    /**
     * Add idhabilidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Habilidad $idhabilidad
     * @return Plaza
     */
    public function addIdhabilidad(\SIGESRHI\AdminBundle\Entity\Habilidad $idhabilidad)
    {
        $this->idhabilidad[] = $idhabilidad;
    
        return $this;
    }

    /**
     * Remove idhabilidad
     *
     * @param \SIGESRHI\AdminBundle\Entity\Habilidad $idhabilidad
     */
    public function removeIdhabilidad(\SIGESRHI\AdminBundle\Entity\Habilidad $idhabilidad)
    {
        $this->idhabilidad->removeElement($idhabilidad);
    }

    /**
     * Get idhabilidad
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdhabilidad()
    {
        return $this->idhabilidad;
    }

    /**
     * Add idmanejoequipo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Manejoequipo $idmanejoequipo
     * @return Plaza
     */
    public function addIdmanejoequipo(\SIGESRHI\AdminBundle\Entity\Manejoequipo $idmanejoequipo)
    {
        $this->idmanejoequipo[] = $idmanejoequipo;
    
        return $this;
    }

    /**
     * Remove idmanejoequipo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Manejoequipo $idmanejoequipo
     */
    public function removeIdmanejoequipo(\SIGESRHI\AdminBundle\Entity\Manejoequipo $idmanejoequipo)
    {
        $this->idmanejoequipo->removeElement($idmanejoequipo);
    }

    /**
     * Get idmanejoequipo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdmanejoequipo()
    {
        return $this->idmanejoequipo;
    }

    /**
     * Add iddocautorizacion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Docautorizacionplaza $iddocautorizacion
     * @return Plaza
     */
    public function addIddocautorizacion(\SIGESRHI\AdminBundle\Entity\Docautorizacionplaza $iddocautorizacion)
    {
        $this->iddocautorizacion[] = $iddocautorizacion;
    
        return $this;
    }

    /**
     * Remove iddocautorizacion
     *
     * @param \SIGESRHI\AdminBundle\Entity\Feature $iddocautorizacion
     */
    public function removeIddocautorizacion(\SIGESRHI\AdminBundle\Entity\Docautorizacionplaza $iddocautorizacion)
    {
        $this->iddocautorizacion->removeElement($iddocautorizacion);
    }

    /**
     * Get iddocautorizacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIddocautorizacion()
    {
        return $this->iddocautorizacion;
    }
    
    /***  Manejo de archivos  ***/
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }
    
    /* Definir directorio donde se guardarán archivos */
    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/documents';
    }
    
    /*  fin directorio **/


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        
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
    
    public function upload($basepath)
    {
    // the file property can be empty if the field is not required
    if (null === $this->getFile()) {
        return;
    }
   if(null===$basepath){return;}
    // aquí usa el nombre de archivo original pero lo debes
    // sanear al menos para evitar cualquier problema de seguridad

    // move takes the target directory and then the
    // target filename to move to
    $prefijo = substr(md5(uniqid(rand())),0,6); //Clave aleatoria de 6 caracteres
    $this->getFile()->move(
        $this->getUploadRootDir($basepath),
        $prefijo.$this->getFile()->getClientOriginalName()
    );

    // set the path property to the filename where you've saved the file
    $this->path = $prefijo.$this->getFile()->getClientOriginalName();

    // limpia la propiedad «file» ya que no la necesitas más
    $this->file = null;
}

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdated(date('Y-m-d H:i:s'));
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
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set updated
     *
     * @param string $updated
     * @return Image
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return string 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }

    /**
     * Set experiencia
     *
     * @param integer $experiencia
     * @return Plaza
     */
    public function setExperiencia($experiencia)
    {
        $this->experiencia = $experiencia;
    
        return $this;
    }

    /**
     * Get experiencia
     *
     * @return integer 
     */
    public function getExperiencia()
    {
        return $this->experiencia;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Plaza
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
     * Add idtitulo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo
     * @return Plaza
     */
    public function addIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo)
    {
        $this->idtitulo[] = $idtitulo;
    
        return $this;
    }

    /**
     * Remove idtitulo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo
     */
    public function removeIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo)
    {
        $this->idtitulo->removeElement($idtitulo);
    }

    /**
     * Get idtitulo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtitulo()
    {
        return $this->idtitulo;
    }

    /**
     * Add idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     * @return Plaza
     */
    public function addIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion[] = $idcontratacion;
    
        return $this;
    }

    /**
     * Remove idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     */
    public function removeIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion->removeElement($idcontratacion);
    }

    /**
     * Get idcontratacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcontratacion()
    {
        return $this->idcontratacion;
    }
}