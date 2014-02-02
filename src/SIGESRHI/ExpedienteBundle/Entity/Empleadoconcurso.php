<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Concursoempleado
 *
 * @ORM\Table(name="empleadoconcurso")
 * @ORM\Entity
 * @Vich\Uploadable
 * @GRID\Source(columns="id,fecharegistro,idconcurso.id", groups={"grupo_empleado_concurso"})
 */
class Empleadoconcurso
{
	/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="idemconcurso_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"grupo_empleado_concurso"}, visible=false)
     */
    private $id;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="idempleadoconcurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idempleado", referencedColumnName="id")
     * })
     * @GRID\Column(field="idempleado.idexpediente.idsolicitudempleo.nombrecompleto", groups={"grupo_empleado_concurso"}, title="Nombre" ,joinType="inner",filterable=false, visible="false")
     */
    private $idempleado;

    /**
     * @var \Concurso
     *
     * @ORM\ManyToOne(targetEntity="Concurso", inversedBy="idempleadoconcurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idconcurso", referencedColumnName="id")
     * })
     * @GRID\Column(field="idconcurso.id", groups={"grupo_empleado_concurso"},joinType="inner", filterable=false, visible=false)
     */
    private $idconcurso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistro", type="date", nullable=false)
     * @GRID\Column(groups={"grupo_empleado_concurso"}, title="Fecha aplicación", filterable=false, type="date", align="center")
     */
    private $fecharegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="docconcurso", type="string", length=200, nullable=true)
     * @Assert\Length(
     * max = "200",
     * maxMessage = "El nombre o ruta del documento no debe exceder los {{limit}} caracteres"
     * )
     *
     */
    private $docconcurso;

    /**
     * @Assert\File(
     * maxSize="2048k",
     * mimeTypes = {"application/pdf", "application/x-pdf", "application/msword"},
     * maxSizeMessage = "El tamaño maximo permitido para el documento es 2MB.",
     * mimeTypesMessage = "El documento debe tener un formato word o pdf."
     * )
     *
     * @Vich\UploadableField(mapping="docs_concurso", fileNameProperty="docconcurso")
     *
     */
    private $file;


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
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return Empleadoconcurso
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
     * Set docconcurso
     *
     * @param string $docconcurso
     * @return Empleadoconcurso
     */
    public function setDocconcurso($docconcurso)
    {
        $this->docconcurso = $docconcurso;
    
        return $this;
    }

    /**
     * Get docconcurso
     *
     * @return string 
     */
    public function getDocconcurso()
    {
        return $this->docconcurso;
    }

    /**
     * Set idempleado
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idempleado
     * @return Empleadoconcurso
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
     * Set idconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Concurso $idconcurso
     * @return Empleadoconcurso
     */
    public function setIdconcurso(\SIGESRHI\ExpedienteBundle\Entity\Concurso $idconcurso = null)
    {
        $this->idconcurso = $idconcurso;
    
        return $this;
    }

    /**
     * Get idconcurso
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Concurso 
     */
    public function getIdconcurso()
    {
        return $this->idconcurso;
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
    
}