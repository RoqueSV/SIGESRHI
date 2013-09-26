<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informaciomacademica
 *
 * @ORM\Table(name="informaciomacademica")
 * @ORM\Entity
 */
class Informacionacademica
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Titulo", inversedBy="idinformacionacademica")
     * @ORM\JoinTable(name="tituloinformacion",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idinformacion", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idtitulo", referencedColumnName="id")
     *   }
     * )
     */
    private $idtitulo;

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
     * @param \SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo $idsolicitudempleo
     * @return Informaciomacademica
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idtitulo = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idtitulo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo
     * @return Informaciomacademica
     */
    public function addIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo)
    {
        $this->idtitulo[] = $idtitulo;
    
        return $this;
    }

    /**
     * Remove idtitulo
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo
     */
    public function removeIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo)
    {
        $this->idtitulo->removeElement($idtitulo);
    }

    /**
     * Get idtitulo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtitulo()
    {
        return $this->idtitulo;
    }
}