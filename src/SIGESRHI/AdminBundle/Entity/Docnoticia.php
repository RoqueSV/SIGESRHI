<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Docnoticia
 *
 * @ORM\Table(name="docnoticia")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Docnoticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="docnoticia_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredocnoticia", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del archivo")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre de la noticia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombredocnoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="rutadocnoticia", type="string", length=150, nullable=false)
     * @Assert\Length(
     * max = "150",
     * maxMessage = "La ruta de la noticia no debe exceder los {{limit}} caracteres"
     * )
     *
     */
    private $rutadocnoticia;

    /**
     * @Assert\File(
     * maxSize="2048k",
     * mimeTypes = {"image/jpeg", "image/png", "application/pdf", "application/msword", "application/zip"},
     * maxSizeMessage = "El tamaño maximo permitido es 2MB.",
     * mimeTypesMessage = "Por favor suba un archivo válido (formato JPEG, PNG, PDF o DOC)."
     * )
     *
     * @Vich\UploadableField(mapping="docs_docsnoticia", fileNameProperty="rutadocnoticia")
     *
     */
    private $file;

    /**
     * @var \Noticia
     *
     * @ORM\ManyToOne(targetEntity="Noticia", inversedBy="iddocnoticia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idnoticia", referencedColumnName="id")
     * })
     */
    private $idnoticia;


    public function __toString()
    {
        return $this->nombredocnoticia;
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
     * Set nombredocnoticia
     *
     * @param string $nombredocnoticia
     * @return Docnoticia
     */
    public function setNombredocnoticia($nombredocnoticia)
    {
        $this->nombredocnoticia = $nombredocnoticia;
    
        return $this;
    }

    /**
     * Get nombredocnoticia
     *
     * @return string 
     */
    public function getNombredocnoticia()
    {
        return $this->nombredocnoticia;
    }

    /**
     * Set rutadocnoticia
     *
     * @param string $rutadocnoticia
     * @return Docnoticia
     */
    public function setRutadocnoticia($rutadocnoticia)
    {
        $this->rutadocnoticia = $rutadocnoticia;
    
        return $this;
    }

    /**
     * Get rutadocnoticia
     *
     * @return string 
     */
    public function getRutadocnoticia()
    {
        return $this->rutadocnoticia;
    }

    /**
     * Set idnoticia
     *
     * @param \SIGESRHI\AdminBundle\Entity\Noticia $idnoticia
     * @return Docnoticia
     */
    public function setIdnoticia(\SIGESRHI\AdminBundle\Entity\Noticia $idnoticia = null)
    {
        $this->idnoticia = $idnoticia;
    
        return $this;
    }

    /**
     * Get idnoticia
     *
     * @return \SIGESRHI\AdminBundle\Entity\Noticia 
     */
    public function getIdnoticia()
    {
        return $this->idnoticia;
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