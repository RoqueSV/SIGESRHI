<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Beneficiario
 *
 * @ORM\Table(name="beneficiario")
 * @ORM\Entity
 * @Vich\Uploadable 
 */
class Beneficiario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="beneficiario_id_seq", allocationSize=1, initialValue=1)
     *
     *
     * @GRID\Column(title="Codigo", filter="input", searchOnClick="true")
     * 
     * 
     */

    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrebeneficiario", type="string", length=50, nullable=false)
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del beneficiario no debe exceder los {{limit}} caracteres"
     * )
     *
     *
     * @GRID\Column(title="Nombre", filter="input")
     * 
     * 
     */
    private $nombrebeneficiario;

    /**
     * @var string
     *
     * @ORM\Column(name="parentescobeneficiario", type="string", length=10, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el parentezco del beneficiario")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El parentezco del beneficiario no debe exceder los {{limit}} caracteres"
     * )
     *
     *
     * @GRID\Column(title="Parentesco", filterable=false)
     */
    private $parentescobeneficiario;

    /**
     * @var integer
     *
     * @ORM\Column(name="porcentaje", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el porcentaje")
     *
     *
     * @GRID\Column(title="%", filterable=false)
     * 
     * 
     */
    private $porcentaje;

    /**
     * @var \Segurovida
     *
     * @ORM\ManyToOne(targetEntity="Segurovida", inversedBy="idbeneficiario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsegurovida", referencedColumnName="id")
     * })
     *@GRID\Column(field="idsegurovida.estadoseguro", title="Cod_seguro", filter="input")
     */
    private $idsegurovida;

    /*** Ejemplo vich uploader --  Será removido ***/
     
     /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "application/pdf", "application/x-pdf"}
     * )
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File $image
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

     /*** Metodos setter y getter ***/

     /**
     * Set imageName
     *
     * @param string $imageName
     * @return Beneficiario
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setImage(UploadedFile $image = null)
    {
        $this->image = $image;
        
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
        
    }

    /********************* Aqui termina ejemplo ***************************/

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
     * Set nombrebeneficiario
     *
     * @param string $nombrebeneficiario
     * @return Beneficiario
     */
    public function setNombrebeneficiario($nombrebeneficiario)
    {
        $this->nombrebeneficiario = $nombrebeneficiario;
    
        return $this;
    }

    /**
     * Get nombrebeneficiario
     *
     * @return string 
     */
    public function getNombrebeneficiario()
    {
        return $this->nombrebeneficiario;
    }

    /**
     * Set parentescobeneficiario
     *
     * @param string $parentescobeneficiario
     * @return Beneficiario
     */
    public function setParentescobeneficiario($parentescobeneficiario)
    {
        $this->parentescobeneficiario = $parentescobeneficiario;
    
        return $this;
    }

    /**
     * Get parentescobeneficiario
     *
     * @return string 
     */
    public function getParentescobeneficiario()
    {
        return $this->parentescobeneficiario;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Beneficiario
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;
    
        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set idsegurovida
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida
     * @return Beneficiario
     */
    public function setIdsegurovida(\SIGESRHI\ExpedienteBundle\Entity\Segurovida $idsegurovida = null)
    {
        $this->idsegurovida = $idsegurovida;
    
        return $this;
    }

    /**
     * Get idsegurovida
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Segurovida 
     */
    public function getIdsegurovida()
    {
        return $this->idsegurovida;
    }
}