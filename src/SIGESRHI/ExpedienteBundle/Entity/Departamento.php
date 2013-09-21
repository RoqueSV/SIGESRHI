<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity
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
     * @Assert\Length(max="15")
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
}