<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado")
 * @ORM\Entity
 */
class Empleado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="empleado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idrol", type="integer", nullable=false)
     */
    private $idrol;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoempleado", type="string", length=5, nullable=false)
     */
    private $codigoempleado;

        /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     */
    private $idexpediente;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="emp_idusuario", referencedColumnName="id")
     * })
     */
    private $empusuario;

         public function __toString() {
  return $this->codigoempleado;
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
     * Set idrol
     *
     * @param integer $idrol
     * @return Empleado
     */
    public function setIdrol($idrol)
    {
        $this->idrol = $idrol;
    
        return $this;
    }

    /**
     * Get idrol
     *
     * @return integer 
     */
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set codigoempleado
     *
     * @param string $codigoempleado
     * @return Empleado
     */
    public function setCodigoempleado($codigoempleado)
    {
        $this->codigoempleado = $codigoempleado;
    
        return $this;
    }

    /**
     * Get codigoempleado
     *
     * @return string 
     */
    public function getCodigoempleado()
    {
        return $this->codigoempleado;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\AdminBundle\Entity\Expediente $idexpediente
     * @return Empleado
     */
    public function setIdexpediente(\SIGESRHI\AdminBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\AdminBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }

    /**
     * Set empusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Empleado $empusuario
     * @return Empleado
     */
    public function setEmpusuario(\SIGESRHI\AdminBundle\Entity\Empleado $empusuario = null)
    {
        $this->empusuario = $empusuario;
    
        return $this;
    }

    /**
     * Get empusuario
     *
     * @return \SIGESRHI\AdminBundle\Entity\Empleado 
     */
    public function getEmpusuario()
    {
        return $this->empusuario;
    }
}