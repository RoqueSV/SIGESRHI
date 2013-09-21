<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Titulo
 *
 * @ORM\Table(name="titulo")
 * @ORM\Entity
 */
class Titulo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="titulo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombretitulo", type="string", length=50, nullable=false)
     */
    private $nombretitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="niveltitulo", type="string", length=20, nullable=false)
     */
    private $niveltitulo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Informacionacademica", mappedBy="idtitulo")
     */
    private $idinformacionacademica;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\SIGESRHI\AdminBundle\Entity\Plaza", mappedBy="idtitulo")
     */
    private $idplaza;

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
     * Set nombretitulo
     *
     * @param string $nombretitulo
     * @return Titulo
     */
    public function setNombretitulo($nombretitulo)
    {
        $this->nombretitulo = $nombretitulo;
    
        return $this;
    }

    /**
     * Get nombretitulo
     *
     * @return string 
     */
    public function getNombretitulo()
    {
        return $this->nombretitulo;
    }

    /**
     * Set niveltitulo
     *
     * @param string $niveltitulo
     * @return Titulo
     */
    public function setNiveltitulo($niveltitulo)
    {
        $this->niveltitulo = $niveltitulo;
    
        return $this;
    }

    /**
     * Get niveltitulo
     *
     * @return string 
     */
    public function getNiveltitulo()
    {
        return $this->niveltitulo;
    }


    /**
     * Get idinformacionacademica
     *
     * @return \SIGESRHI\AdminBundle\Entity\Informacionacademica 
     */
    public function getIdinformacionacademica()
    {
        return $this->idinformacionacademica;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idinformacionacademica = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idplaza = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idinformacionacademica
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $idinformacionacademica
     * @return Titulo
     */
    public function addIdinformacionacademica(\SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $idinformacionacademica)
    {
        $this->idinformacionacademica[] = $idinformacionacademica;
    
        return $this;
    }

    /**
     * Remove idinformacionacademica
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $idinformacionacademica
     */
    public function removeIdinformacionacademica(\SIGESRHI\ExpedienteBundle\Entity\Informacionacademica $idinformacionacademica)
    {
        $this->idinformacionacademica->removeElement($idinformacionacademica);
    }

    /**
     * Add idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     * @return Titulo
     */
    public function addIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza)
    {
        $this->idplaza[] = $idplaza;
    
        return $this;
    }

    /**
     * Remove idplaza
     *
     * @param \SIGESRHI\AdminBundle\Entity\Plaza $idplaza
     */
    public function removeIdplaza(\SIGESRHI\AdminBundle\Entity\Plaza $idplaza)
    {
        $this->idplaza->removeElement($idplaza);
    }

    /**
     * Get idplaza
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdplaza()
    {
        return $this->idplaza;
    }
}