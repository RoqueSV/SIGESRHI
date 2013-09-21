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
     * @var \Informaciomacademica
     *
     * @ORM\ManyToOne(targetEntity="Informaciomacademica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idinformacionacademica", referencedColumnName="id")
     * })
     */
    private $idinformacionacademica;



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
     * Set idinformacionacademica
     *
     * @param \SIGESRHI\AdminBundle\Entity\Informaciomacademica $idinformacionacademica
     * @return Titulo
     */
    public function setIdinformacionacademica(\SIGESRHI\AdminBundle\Entity\Informaciomacademica $idinformacionacademica = null)
    {
        $this->idinformacionacademica = $idinformacionacademica;
    
        return $this;
    }

    /**
     * Get idinformacionacademica
     *
     * @return \SIGESRHI\AdminBundle\Entity\Informaciomacademica 
     */
    public function getIdinformacionacademica()
    {
        return $this->idinformacionacademica;
    }
}