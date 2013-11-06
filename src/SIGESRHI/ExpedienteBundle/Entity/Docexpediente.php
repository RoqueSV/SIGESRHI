<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Docexpediente
 *
 * @ORM\Table(name="docexpediente")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Docexpediente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docexpediente_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocexp", type="string", length=25, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del doc")
     * @Assert\Length(
     * max = "25",
     * maxMessage = "El nombre registrado del documento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombredocexp;

    /**
     * @var string
     *
     * @ORM\Column(name="rutadocexp", type="string")
     */
    private $rutadocexp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadocexp", type="date", nullable=false)
     */
    private $fechadocexp;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente", inversedBy="Docs_expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     */
    private $idexpediente;

    /**
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "application/pdf", "application/x-pdf"}
     * )
     * @Vich\UploadableField(mapping="docs_expediente", fileNameProperty="rutadocexp")
     *
     * @var File $file
     */
    protected $file;


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
     * Set nombredocexp
     *
     * @param string $nombredocexp
     * @return Docexpediente
     */
    public function setNombredocexp($nombredocexp)
    {
        $this->nombredocexp = $nombredocexp;
    
        return $this;
    }

    /**
     * Get nombredocexp
     *
     * @return string 
     */
    public function getNombredocexp()
    {
        return $this->nombredocexp;
    }

    /**
     * Set rutadocexp
     *
     * @param string $rutadocexp
     * @return Docexpediente
     */
    public function setRutadocexp($rutadocexp)
    {
        $this->rutadocexp = $rutadocexp;
    
        return $this;
    }

    /**
     * Get rutadocexp
     *
     * @return string 
     */
    public function getRutadocexp()
    {
        return $this->rutadocexp;
    }

    /**
     * Set fechadocexp
     *
     * @param \DateTime $fechadocexp
     * @return Docexpediente
     */
    public function setFechadocexp($fechadocexp)
    {
        $this->fechadocexp = $fechadocexp;
    
        return $this;
    }

    /**
     * Get fechadocexp
     *
     * @return \DateTime 
     */
    public function getFechadocexp()
    {
        return $this->fechadocexp;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Docexpediente
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
}