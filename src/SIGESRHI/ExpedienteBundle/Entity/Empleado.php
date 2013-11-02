<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="codigoempleado", type="string", length=5, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el codigo del empleado")
     * @Assert\Length(
     * max = "5",
     * maxMessage = "El codigo de empleado no debe exceder los {{limit}} caracteres"
     * )
     */
    private $codigoempleado;

    /**
     * @var \Expediente
     *
     * @ORM\OneToOne(targetEntity="Expediente", inversedBy="idempleado")
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
     *   @ORM\JoinColumn(name="idjefe", referencedColumnName="id")
     * })
     */
    private $idjefe;

    /**
     * @var \Usuario
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $idusuario;

    /**
     * @ORM\OneToMany(targetEntity="Contratacion", mappedBy="idempleado")
     */
    private $idcontratacion;

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
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Empleado
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

    /**
     * Set idjefe
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe
     * @return Empleado
     */
    public function setIdjefe(\SIGESRHI\ExpedienteBundle\Entity\Empleado $idjefe = null)
    {
        $this->idjefe = $idjefe;
    
        return $this;
    }

    /**
     * Get idjefe
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Empleado 
     */
    public function getIdjefe()
    {
        return $this->idjefe;
    }

    /**
     * Set idusuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuario
     * @return Empleado
     */
    public function setIdusuario(\Application\Sonata\UserBundle\Entity\User $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcontratacion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     * @return Empleado
     */
    public function addIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion[] = $idcontratacion;
    
        return $this;
    }

    /**
     * Remove idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     */
    public function removeIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion->removeElement($idcontratacion);
    }

    /**
     * Get idcontratacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcontratacion()
    {
        return $this->idcontratacion;
    }
}