<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Memorandum
 *
 * @ORM\Table(name="memorandum")
 * @ORM\Entity
 */
class Memorandum
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="memorandum_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="correlativo", type="integer", nullable=false)
     */
    private $correlativo;

    /**
     * @var \Concurso
     *
     * @ORM\ManyToOne(targetEntity="Concurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idconcurso", referencedColumnName="id")
     * })
     */
    private $idconcurso;



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
     * Set correlativo
     *
     * @param integer $correlativo
     * @return Memorandum
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;
    
        return $this;
    }

    /**
     * Get correlativo
     *
     * @return integer 
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * Set idconcurso
     *
     * @param \SIGESRHI\AdminBundle\Entity\Concurso $idconcurso
     * @return Memorandum
     */
    public function setIdconcurso(\SIGESRHI\AdminBundle\Entity\Concurso $idconcurso = null)
    {
        $this->idconcurso = $idconcurso;
    
        return $this;
    }

    /**
     * Get idconcurso
     *
     * @return \SIGESRHI\AdminBundle\Entity\Concurso 
     */
    public function getIdconcurso()
    {
        return $this->idconcurso;
    }
}