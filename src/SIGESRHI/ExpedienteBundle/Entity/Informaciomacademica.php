<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informaciomacademica
 *
 * @ORM\Table(name="informaciomacademica")
 * @ORM\Entity
 */
class Informaciomacademica
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="informaciomacademica_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="centroestudio", type="string", length=50, nullable=false)
     */
    private $centroestudio;

    /**
     * @var \Solicitudempleo
     *
     * @ORM\ManyToOne(targetEntity="Solicitudempleo")
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
     * Set centroestudio
     *
     * @param string $centroestudio
     * @return Informaciomacademica
     */
    public function setCentroestudio($centroestudio)
    {
        $this->centroestudio = $centroestudio;
    
        return $this;
    }

    /**
     * Get centroestudio
     *
     * @return string 
     */
    public function getCentroestudio()
    {
        return $this->centroestudio;
    }

    /**
     * Set idsolicitudempleo
     *
     * @param \SIGESRHI\AdminBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Informaciomacademica
     */
    public function setIdsolicitudempleo(\SIGESRHI\AdminBundle\Entity\Solicitudempleo $idsolicitudempleo = null)
    {
        $this->idsolicitudempleo = $idsolicitudempleo;
    
        return $this;
    }

    /**
     * Get idsolicitudempleo
     *
     * @return \SIGESRHI\AdminBundle\Entity\Solicitudempleo 
     */
    public function getIdsolicitudempleo()
    {
        return $this->idsolicitudempleo;
    }
}