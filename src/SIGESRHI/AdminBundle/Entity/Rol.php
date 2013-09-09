<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="rol")
 * @ORM\Entity
 */
class Rol
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="rol_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrerol", type="string", length=20, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del rol")
     * @Assert\Length(max="20")
     */
    private $nombrerol;
  
        public function __toString() {
  return $this->nombrerol;
}

    /**
     * @ORM\ManyToMany(targetEntity="Acceso", mappedBy="idrol")
     */
    private $idacceso;
    
     /**
     *@ORM\OneToMany(targetEntity="Usuario", mappedBy="idrol")
     */
    private $idusuario;

    public function __construct()
    {
        $this->idacceso = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombrerol
     *
     * @param string $nombrerol
     * @return Rol
     */
    public function setNombrerol($nombrerol)
    {
        $this->nombrerol = $nombrerol;
    
        return $this;
    }

    /**
     * Get nombrerol
     *
     * @return string 
     */
    public function getNombrerol()
    {
        return $this->nombrerol;
    }

    /**
     * Add idacceso
     *
     * @param \SIGESRHI\AdminBundle\Entity\Acceso $idacceso
     * @return Rol
     */
    public function addIdacceso(\SIGESRHI\AdminBundle\Entity\Acceso $idacceso)
    {
        $this->idacceso[] = $idacceso;
    
        return $this;
    }

    /**
     * Remove idacceso
     *
     * @param \SIGESRHI\AdminBundle\Entity\Acceso $idacceso
     */
    public function removeIdacceso(\SIGESRHI\AdminBundle\Entity\Acceso $idacceso)
    {
        $this->idacceso->removeElement($idacceso);
    }

    /**
     * Get idacceso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdacceso()
    {
        return $this->idacceso;
    }

    /**
     * Add idusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Usuario $idusuario
     * @return Rol
     */
    public function addIdusuario(\SIGESRHI\AdminBundle\Entity\Usuario $idusuario)
    {
        $this->idusuario[] = $idusuario;
    
        return $this;
    }

    /**
     * Remove idusuario
     *
     * @param \SIGESRHI\AdminBundle\Entity\Usuario $idusuario
     */
    public function removeIdusuario(\SIGESRHI\AdminBundle\Entity\Usuario $idusuario)
    {
        $this->idusuario->removeElement($idusuario);
    }

    /**
     * Get idusuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}