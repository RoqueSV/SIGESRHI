<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Beneficiario
 *
 * @ORM\Table(name="beneficiario")
 * @ORM\Entity
 * 
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
     */
    private $parentescobeneficiario;

    /**
     * @var integer
     *
     * @ORM\Column(name="porcentaje", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el porcentaje")
     * @Assert\Range(
     *      min = "1",
     *      max = "100",
     *      minMessage = "Debe ingresar un valor mayor a 0",
     *      maxMessage = "Valores mayores a 100 no están permitidos"
     * )
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
     */
    private $idsegurovida;
    

    public function __toString(){
        return $this->getNombrebeneficiario();
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