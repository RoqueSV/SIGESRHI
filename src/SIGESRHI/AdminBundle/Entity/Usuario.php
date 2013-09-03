<?php

namespace SIGESRHI\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 */
class Usuario extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="usuario_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var \Rol
     *
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idrol", referencedColumnName="id")
     * })
     */
    private $idrol;



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
     * @param \SIGESRHI\AdminBundle\Entity\Rol $idrol
     * @return Usuario
     */
    public function setIdrol(\SIGESRHI\AdminBundle\Entity\Rol $idrol = null)
    {
        $this->idrol = $idrol;
    
        return $this;
    }

    /**
     * Get idrol
     *
     * @return \SIGESRHI\AdminBundle\Entity\Rol 
     */
    public function getIdrol()
    {
        return $this->idrol;
    }
}