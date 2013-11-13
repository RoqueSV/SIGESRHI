<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Datosfamiliares
 *
 * @ORM\Table(name="datosfamiliares")
 * @ORM\Entity
 */
class Datosfamiliares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="datosfamiliares_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrefamiliar", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del familiar")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del familiar no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrefamiliar;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionfamiliar", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la direccion del familiar")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "La direccion del familiar no debe exceder los {{limit}} caracteres"
     * )
     */
    private $direccionfamiliar;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonofamiliar", type="string", length=9, nullable=false)
      * @Assert\NotNull(message="Debe ingresar el telefono del familiar")
     * @Assert\Length(
     * max = "9",
     * maxMessage = "El telefono del familiar no debe exceder los {{limit}} caracteres"
     * )
     */
    private $telefonofamiliar;

    /**
     * @var string
     *
     * @ORM\Column(name="parentesco", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el parentezco con el familiar")
     * @Assert\Length(
     * max = "15",
     * maxMessage = "El parentezco con el familiar no debe exceder los {{limit}} caracteres"
     * )
     */
    private $parentesco;

    /**
     * @var \Solicitudempleo
     *
     * @ORM\ManyToOne(targetEntity="Solicitudempleo", inversedBy="Dfamiliares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsolicitudempleo", referencedColumnName="id")
     * })
     */
    private $idsolicitudempleo;



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
     * Set nombrefamiliar
     *
     * @param string $nombrefamiliar
     * @return Datosfamiliares
     */
    public function setNombrefamiliar($nombrefamiliar)
    {
        $this->nombrefamiliar = $nombrefamiliar;
    
        return $this;
    }

    /**
     * Get nombrefamiliar
     *
     * @return string 
     */
    public function getNombrefamiliar()
    {
        return $this->nombrefamiliar;
    }

    /**
     * Set direccionfamiliar
     *
     * @param string $direccionfamiliar
     * @return Datosfamiliares
     */
    public function setDireccionfamiliar($direccionfamiliar)
    {
        $this->direccionfamiliar = $direccionfamiliar;
    
        return $this;
    }

    /**
     * Get direccionfamiliar
     *
     * @return string 
     */
    public function getDireccionfamiliar()
    {
        return $this->direccionfamiliar;
    }

    /**
     * Set telefonofamiliar
     *
     * @param string $telefonofamiliar
     * @return Datosfamiliares
     */
    public function setTelefonofamiliar($telefonofamiliar)
    {
        $this->telefonofamiliar = $telefonofamiliar;
    
        return $this;
    }

    /**
     * Get telefonofamiliar
     *
     * @return string 
     */
    public function getTelefonofamiliar()
    {
        return $this->telefonofamiliar;
    }

    /**
     * Set parentesco
     *
     * @param string $parentesco
     * @return Datosfamiliares
     */
    public function setParentesco($parentesco)
    {
        $this->parentesco = $parentesco;
    
        return $this;
    }

    /**
     * Get parentesco
     *
     * @return string 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }

    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Datosfamiliares
     */
    public function setIdsolicitudempleo(\SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo = null)
    {
        $this->idsolicitudempleo = $idsolicitudempleo;
    
        return $this;
    }

    /**
     * Get idsolicitudempleo
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo 
     */
    public function getIdsolicitudempleo()
    {
        return $this->idsolicitudempleo;
    }
}