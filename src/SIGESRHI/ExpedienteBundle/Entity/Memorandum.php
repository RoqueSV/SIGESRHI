<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="correlativo", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el correlativo")
     */
    private $correlativo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipomemorandum", type="string", length=1, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el tipo")
     */
    private $tipomemorandum;

    /**
     * @var \Concurso
     *
     * @ORM\ManyToOne(targetEntity="Concurso", inversedBy="idmemorandum")
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
     * @param string $correlativo
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
     * @return string
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }


    /**
     * Set tipomemorandum
     *
     * @param string $tipomemorandum
     * @return Memorandum
     */
    public function setTipomemorandum($tipomemorandum)
    {
        $this->tipomemorandum = $tipomemorandum;
    
        return $this;
    }

    /**
     * Get tipomemorandum
     *
     * @return string
     */
    public function getTipomemorandum()
    {
        return $this->tipomemorandum;
    }

    /**
     * Set idconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Concurso $idconcurso
     * @return Memorandum
     */
    public function setIdconcurso(\SIGESRHI\ExpedienteBundle\Entity\Concurso $idconcurso = null)
    {
        $this->idconcurso = $idconcurso;
    
        return $this;
    }

    /**
     * Get idconcurso
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Concurso 
     */
    public function getIdconcurso()
    {
        return $this->idconcurso;
    }
}