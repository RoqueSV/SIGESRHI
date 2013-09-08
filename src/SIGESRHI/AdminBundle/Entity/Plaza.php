<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plaza
 *
 * @ORM\Table(name="plaza")
 * @ORM\Entity
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
     * @Assert\MaxLength(100)
     */
    private $nombreplaza;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionplaza", type="string", length=500, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la descripcion de la plaza")
     * @Assert\MaxLength(500)
     */
    private $descripcionplaza;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar la edad minima de la plaza")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoplaza", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado de la plaza")
     */
    private $estadoplaza;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Area", inversedBy="idplaza")
     * @ORM\JoinTable(name="areaplaza",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idplaza", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idarea", referencedColumnName="id")
     *   }
     * )
     */
    private $idarea;

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
     * Constructor
     */
    public function __construct()
    {
        $this->idarea = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idconocimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idfuncion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idhabilidad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idmanejoequipo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add idarea
     *
     * @param \SIGESRHI\AdminBundle\Entity\Area $idarea
     * @return Plaza
     */
    public function addIdarea(\SIGESRHI\AdminBundle\Entity\Area $idarea)
    {
        $this->idarea[] = $idarea;
    
        return $this;
    }

    /**
     * Remove idarea
     *
     * @param \SIGESRHI\AdminBundle\Entity\Area $idarea
     */
    public function removeIdarea(\SIGESRHI\AdminBundle\Entity\Area $idarea)
    {
        $this->idarea->removeElement($idarea);
    }

    /**
     * Get idarea
     *
     * @return \Doctrine\Common\Collections\Collection 
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
}