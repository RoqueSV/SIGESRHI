<?php

namespace SIGESRHI\ExpedienteBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity(repositoryClass="SIGESRHI\ExpedienteBundle\Repositorio\DepartamentoRepository")
 */
class Departamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="departamento_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredepartamento", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar un nombre de Departamento")
     * @Assert\Length(
     * max = "15",
     * maxMessage = "El nombre del departamento no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombredepartamento;


 public function __toString() {
        return $this->nombredepartamento;
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
     * Set nombredepartamento
     *
     * @param string $nombredepartamento
     * @return Departamento
     */
    public function setNombredepartamento($nombredepartamento)
    {
        $this->nombredepartamento = $nombredepartamento;
    
        return $this;
    }

    /**
     * Get nombredepartamento
     *
     * @return string 
     */
    public function getNombredepartamento()
    {
        return $this->nombredepartamento;
    }



     /**
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="iddepartamento")
     */
    protected $Municipios;

    public function __construct()
    {
        $this->Municipios = new ArrayCollection();
        
    }


      /**
     * Add Municipios
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Municipio $municipios
     * @return Departamento
     */
    public function addMunicipio(\SIGESRHI\ExpedienteBundle\Entity\Municipio $municipios)
    {
        $this->Municipios[] = $municipios;
    
        return $this;
    }

    /**
     * Remove Municipios
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Municipio $municipios
     */
    public function removeMunicipio(\SIGESRHI\ExpedienteBundle\Entity\Municipio $municipios)
    {
        $this->Municipios->removeElement($municipios);
    }

    /**
     * Get Municipios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->Municipios;
    }
}