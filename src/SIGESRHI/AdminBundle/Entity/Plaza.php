<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use APY\DataGridBundle\Grid\Mapping as GRID;
/**
 * Plaza
 *
 * @ORM\Table(name="plaza")
 * @ORM\Entity
 * @GRID\Source(columns="id,nombreplaza,misionplaza", groups={"grupo_plaza"})
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
     * @GRID\Column(filterable=false, groups="grupo_plaza", visible=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreplaza", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la plaza")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre de la plaza no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(groups="grupo_plaza",title="Nombre plaza", filter="input", operators={"like"}, operatorsVisible=false, align="center")
     */
    private $nombreplaza;


     public function __toString() {
        return $this->getNombreplaza();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="misionplaza", type="text", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion de la plaza")
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La descripcion de la plaza no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(filterable=false, groups="grupo_plaza", title="Misión")
     */
    private $misionplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=200, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la unidad organizativa de la plaza")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "La unidad de la plaza no debe exceder los {{limit}} caracteres"
     * )
     */
    private $unidad;


     /**
     * @var integer
     *
     * @ORM\Column(name="experiencia", type="integer", nullable=true)
     */
    private $experiencia;
    
    /**
     * @var \Plaza
     *
     * @ORM\ManyToOne(targetEntity="Plaza", inversedBy="idplazahija")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idplazasup", referencedColumnName="id")
     * })
     */
    private $idplazasup;

    /**
      * @ORM\OneToMany(targetEntity="Plaza", mappedBy="idplazasup")
      */

    private $idplazahija;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Resultados", inversedBy="idplaza", cascade={"all"})
     * @ORM\JoinTable(name="resultadoplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idresultado", referencedColumnName="id")
     *   }
     * )
     * @Assert\Valid
     */
    private $idresultado;
    
    /**
     * @ORM\OneToMany(targetEntity="Tituloplaza", mappedBy="idplaza", cascade={"all"})
     * @Assert\Valid
     */
    private $idtituloplaza;

    /**
     * @ORM\OneToMany(targetEntity="Idiomasplaza", mappedBy="idplaza", cascade={"all"})
     * @Assert\Valid
     */
    private $ididiomasplaza;

    /**
     * @ORM\OneToMany(targetEntity="RefrendaAct", mappedBy="idplaza")
     */
    private $idrefrenda;
    
    /**
     * @ORM\OneToMany(targetEntity="Conocimientoplaza", mappedBy="idplaza", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $idconocimientoplaza;
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
     * @Assert\Valid
     */
    private $idfuncion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Competencia", inversedBy="idplaza")
     * @ORM\JoinTable(name="competenciaplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idcompetencia", referencedColumnName="id")
     *   }
     * )
     * @Assert\Valid
     */
    private $idcompetencia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Marcoreferencia", inversedBy="idplaza")
     * @ORM\JoinTable(name="marcoreferenciaplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idmarcoreferencia", referencedColumnName="id")
     *   }
     * )
     * @Assert\Valid
     */
    private $idmarcoreferencia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Otrosaspectos", inversedBy="idplaza")
     * @ORM\JoinTable(name="otrosaspectosplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idotrosaspectos", referencedColumnName="id")
     *   }
     * )
     * @Assert\Valid
     */
    private $idotrosaspectos;
   
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
     *     mimeTypes = {"image/png", "image/jpeg", "image/pjpeg", "application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "El archivo debe ser una imagen o archivo pdf")
     */
    private $file;
    
    
    

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
     * Set misionplaza
     *
     * @param string $misionplaza
     * @return Plaza
     */
    public function setMisionplaza($misionplaza)
    {
        $this->misionplaza = $misionplaza;
    
        return $this;
    }

    /**
     * Get misionplaza
     *
     * @return string 
     */
    public function getMisionplaza()
    {
        return $this->misionplaza;
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
        return 'uploads/docs_plaza';
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
     * Add idrefrenda
     *
     * @param \SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda
     * @return Plaza
     */
    public function addIdrefrenda(\SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda)
    {
        $this->idrefrenda[] = $idrefrenda;
    
        return $this;
    }

    /**
     * Remove idrefrenda
     *
     * @param \SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda
     */
    public function removeIdrefrenda(\SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda)
    {
        $this->idrefrenda->removeElement($idrefrenda);
    }

    /**
     * Get idrefrenda
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdrefrenda()
    {
        return $this->idrefrenda;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idplazahija = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idresultado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idtituloplaza = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ididiomasplaza = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idrefrenda = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idconocimientoplaza = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idfuncion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcompetencia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idmarcoreferencia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idotrosaspectos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set unidad
     *
     * @param string $unidad
     * @return Plaza
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
    
        return $this;
    }

    /**
     * Get unidad
     *
     * @return string 
     */
    public function getUnidad()
    {
        return $this->unidad;
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
     * Set idplazasup
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplazasup
     * @return Plaza
     */
    public function setIdplazasup(\SIGESRHI\AdminBundle\Entity\Plaza $idplazasup = null)
    {
        $this->idplazasup = $idplazasup;
    
        return $this;
    }

    /**
     * Get idplazasup
     *
     * @return \SIGESRHI\AdminBundle\Entity\Plaza 
     */
    public function getIdplazasup()
    {
        return $this->idplazasup;
    }

    /**
     * Add idplazahija
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplazahija
     * @return Plaza
     */
    public function addIdplazahija(\SIGESRHI\AdminBundle\Entity\Plaza $idplazahija)
    {
        $this->idplazahija[] = $idplazahija;
    
        return $this;
    }

    /**
     * Remove idplazahija
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplazahija
     */
    public function removeIdplazahija(\SIGESRHI\AdminBundle\Entity\Plaza $idplazahija)
    {
        $this->idplazahija->removeElement($idplazahija);
    }

    /**
     * Get idplazahija
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdplazahija()
    {
        return $this->idplazahija;
    }

    /**
     * Add idresultado
     *
     * @param \SIGESRHI\AdminBundle\Entity\Resultados $idresultado
     * @return Plaza
     */
    public function addIdresultado(\SIGESRHI\AdminBundle\Entity\Resultados $idresultado)
    {
        $this->idresultado[] = $idresultado;
    
        return $this;
    }

    /**
     * Remove idresultado
     *
     * @param \SIGESRHI\AdminBundle\Entity\Resultados $idresultado
     */
    public function removeIdresultado(\SIGESRHI\AdminBundle\Entity\Resultados $idresultado)
    {
        $this->idresultado->removeElement($idresultado);
    }

    /**
     * Get idresultado
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdresultado()
    {
        return $this->idresultado;
    }

    public function setIdtituloplaza($idtituloplaza)
    {
    if (count($idtituloplaza) > 0) {
        foreach ($idtituloplaza as $i) {
            $this->addIdtituloplaza($i);
        }
    }

    return $this;
    }

    /**
     * Add idtituloplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Tituloplaza $idtituloplaza
     * @return Plaza
     */
    public function addIdtituloplaza(\SIGESRHI\AdminBundle\Entity\Tituloplaza $idtituloplaza)
    {
       // $this->idtituloplaza[] = $idtituloplaza;
     
       $idtituloplaza->setIdplaza($this);
       $this->idtituloplaza->add($idtituloplaza);
    }

    /**
     * Remove idtituloplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Tituloplaza $idtituloplaza
     */
    public function removeIdtituloplaza(\SIGESRHI\AdminBundle\Entity\Tituloplaza $idtituloplaza)
    {
        $this->idtituloplaza->removeElement($idtituloplaza);
    }

    /**
     * Get idtituloplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtituloplaza()
    {
        return $this->idtituloplaza;
    }


    public function setIdidiomasplaza($ididiomasplaza)
    {
    if (count($ididiomasplaza) > 0) {
        foreach ($ididiomasplaza as $i) {
            $this->addIdidiomasplaza($i);
        }
    }

    return $this;
    }

    /**
     * Add ididiomasplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza
     * @return Plaza
     */
    public function addIdidiomasplaza(\SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza)
    {
       /* $this->ididiomasplaza[] = $ididiomasplaza;
    
        return $this;*/
       $ididiomasplaza->setIdplaza($this);
       $this->ididiomasplaza->add($ididiomasplaza);
    }

    /**
     * Remove ididiomasplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza
     */
    public function removeIdidiomasplaza(\SIGESRHI\AdminBundle\Entity\Idiomasplaza $ididiomasplaza)
    {
        $this->ididiomasplaza->removeElement($ididiomasplaza);
    }

    /**
     * Get ididiomasplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdidiomasplaza()
    {
        return $this->ididiomasplaza;
    }


    public function setIdconocimientoplaza($idconocimientoplaza)
    {
    if (count($idconocimientoplaza) > 0) {
        foreach ($idconocimientoplaza as $i) {
            $this->addIdconocimientoplaza($i);
        }
    }

    return $this;
    }
    /**
     * Add idconocimientoplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza
     * @return Plaza
     */
    public function addIdconocimientoplaza(\SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza)
    {
       /*$this->idconocimientoplaza[] = $idconocimientoplaza;
    
        return $this;*/
       $idconocimientoplaza->setIdplaza($this);
       $this->idconocimientoplaza->add($idconocimientoplaza);
    }

    /**
     * Remove idconocimientoplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza
     */
    public function removeIdconocimientoplaza(\SIGESRHI\AdminBundle\Entity\Conocimientoplaza $idconocimientoplaza)
    {
        $this->idconocimientoplaza->removeElement($idconocimientoplaza);
    }

    /**
     * Get idconocimientoplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdconocimientoplaza()
    {
        return $this->idconocimientoplaza;
    }

    
    /**
     * Remove idcompetencia
     *
     * @param \SIGESRHI\AdminBundle\Entity\Competencia $idcompetencia
     */
    public function removeIdcompetencia(\SIGESRHI\AdminBundle\Entity\Competencia $idcompetencia)
    {
        $this->idcompetencia->removeElement($idcompetencia);
    }

    public function setIdcompetencia($idcompetencia)
    {
    if (count($idcompetencia) > 0) {
        foreach ($idcompetencia as $i) {
            $this->addIdcompetencia($i);
        }
     }
    }

    public function addIdcompetencia(\SIGESRHI\AdminBundle\Entity\Competencia $idcompetencia)
    {
       /*$this->idconocimientoplaza[] = $idconocimientoplaza;
    
        return $this;*/
       $idcompetencia->setIdplaza($this);
       $this->idcompetencia->add($idcompetencia);
    }

    /**
     * Get idcompetencia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcompetencia()
    {
        return $this->idcompetencia;
    }

    /**
     * Remove idmarcoreferencia
     *
     * @param \SIGESRHI\AdminBundle\Entity\Marcoreferencia $idmarcoreferencia
     */
    public function removeIdmarcoreferencia(\SIGESRHI\AdminBundle\Entity\Marcoreferencia $idmarcoreferencia)
    {
        $this->idmarcoreferencia->removeElement($idmarcoreferencia);
    }

    public function setIdmarcoreferencia($idmarcoreferencia)
    {
    if (count($idmarcoreferencia) > 0) {
        foreach ($idmarcoreferencia as $i) {
            $this->addIdmarcoreferencia($i);
        }
     }
    }

    public function addIdmarcoreferencia(\SIGESRHI\AdminBundle\Entity\Marcoreferencia $idmarcoreferencia)
    {
       /*$this->idconocimientoplaza[] = $idconocimientoplaza;
    
        return $this;*/
       $idmarcoreferencia->setIdplaza($this);
       $this->idmarcoreferencia->add($idmarcoreferencia);
    }

    /**
     * Get idmarcoreferencia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdmarcoreferencia()
    {
        return $this->idmarcoreferencia;
    }

    /**
     * Add idotrosaspectos
     *
     * @param \SIGESRHI\AdminBundle\Entity\Otrosaspectos $idotrosaspectos
     * @return Plaza
     */
    public function addIdotrosaspecto(\SIGESRHI\AdminBundle\Entity\Otrosaspectos $idotrosaspectos)
    {
        $this->idotrosaspectos[] = $idotrosaspectos;
    
        return $this;
    }

    /**
     * Remove idotrosaspectos
     *
     * @param \SIGESRHI\AdminBundle\Entity\Otrosaspectos $idotrosaspectos
     */
    public function removeIdotrosaspecto(\SIGESRHI\AdminBundle\Entity\Otrosaspectos $idotrosaspectos)
    {
        $this->idotrosaspectos->removeElement($idotrosaspectos);
    }

    /**
     * Get idotrosaspectos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdotrosaspectos()
    {
        return $this->idotrosaspectos;
    }
}