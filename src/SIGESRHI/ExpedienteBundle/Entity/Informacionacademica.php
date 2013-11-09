<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Informacionacademica
 *
 * @ORM\Table(name="informacionacademica")
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
     * @ORM\SequenceGenerator(sequenceName="informacionacademica_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="centroestudio", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del centro de estudio")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El nombre del centro de estudio no debe exceder los {{limit}} caracteres"
     * )
     */
    private $centroestudio;

    /**
     * @var \Solicitudempleo
     *
     * @ORM\ManyToOne(targetEntity="Solicitudempleo", inversedBy="Destudios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsolicitudempleo", referencedColumnName="id")
     * })
     */

    private $idsolicitudempleo;

     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToOne(targetEntity="Titulo", inversedBy="idinformacionacademica")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idtitulo", referencedColumnName="id")
     *})
     */
    private $idtitulo;

    public function __toString(){
        return $this-> getCentroestudio();
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
     * Set centroestudio
     *
     * @param string $centroestudio
     * @return Informacionacademica
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
     * Get idtitulo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdtitulo()
    {
        return $this->idtitulo;
    }


    //agregado manualmente
    public function setIdtitulo(\SIGESRHI\ExpedienteBundle\Entity\Titulo $idtitulo = null)
    {
         $this->idtitulo = $idtitulo;
    
        return $this;
        
    }
}