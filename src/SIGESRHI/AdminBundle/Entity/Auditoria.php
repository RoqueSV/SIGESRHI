<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auditoria
 *
 * @ORM\Table(name="auditoria")
 * @ORM\Entity
 */
class Auditoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="auditoria_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="accionrealizada", type="string", length=10, nullable=false)
     */
    private $accionrealizada;

    /**
     * @var string
     *
     * @ORM\Column(name="tablaafectada", type="string", length=25, nullable=false)
     */
    private $tablaafectada;

    /**
     * @var string
     *
     * @ORM\Column(name="valorold", type="text", nullable=true)
     */
    private $valorold;

    /**
     * @var string
     *
     * @ORM\Column(name="valornew", type="text", nullable=true)
     */
    private $valornew;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioaccion", type="string", length=20, nullable=false)
     */
    private $usuarioaccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaaccion", type="date", nullable=false)
     */
    private $fechaaccion;



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
     * Set accionrealizada
     *
     * @param string $accionrealizada
     * @return Auditoria
     */
    public function setAccionrealizada($accionrealizada)
    {
        $this->accionrealizada = $accionrealizada;
    
        return $this;
    }

    /**
     * Get accionrealizada
     *
     * @return string 
     */
    public function getAccionrealizada()
    {
        return $this->accionrealizada;
    }

    /**
     * Set tablaafectada
     *
     * @param string $tablaafectada
     * @return Auditoria
     */
    public function setTablaafectada($tablaafectada)
    {
        $this->tablaafectada = $tablaafectada;
    
        return $this;
    }

    /**
     * Get tablaafectada
     *
     * @return string 
     */
    public function getTablaafectada()
    {
        return $this->tablaafectada;
    }

    /**
     * Set valorold
     *
     * @param string $valorold
     * @return Auditoria
     */
    public function setValorold($valorold)
    {
        $this->valorold = $valorold;
    
        return $this;
    }

    /**
     * Get valorold
     *
     * @return string 
     */
    public function getValorold()
    {
        return $this->valorold;
    }

    /**
     * Set valornew
     *
     * @param string $valornew
     * @return Auditoria
     */
    public function setValornew($valornew)
    {
        $this->valornew = $valornew;
    
        return $this;
    }

    /**
     * Get valornew
     *
     * @return string 
     */
    public function getValornew()
    {
        return $this->valornew;
    }

    /**
     * Set usuarioaccion
     *
     * @param string $usuarioaccion
     * @return Auditoria
     */
    public function setUsuarioaccion($usuarioaccion)
    {
        $this->usuarioaccion = $usuarioaccion;
    
        return $this;
    }

    /**
     * Get usuarioaccion
     *
     * @return string 
     */
    public function getUsuarioaccion()
    {
        return $this->usuarioaccion;
    }

    /**
     * Set fechaaccion
     *
     * @param \DateTime $fechaaccion
     * @return Auditoria
     */
    public function setFechaaccion($fechaaccion)
    {
        $this->fechaaccion = $fechaaccion;
    
        return $this;
    }

    /**
     * Get fechaaccion
     *
     * @return \DateTime 
     */
    public function getFechaaccion()
    {
        return $this->fechaaccion;
    }
}