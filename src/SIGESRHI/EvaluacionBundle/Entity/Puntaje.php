<?php

namespace SIGESRHI\EvaluacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Puntaje
 *
 * @ORM\Table(name="puntaje")
 * @ORM\Entity
 */
class Puntaje
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="puntaje_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombrepuntaje", type="string", length=15, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del puntaje")
     * @Assert\Length(
     * max = "15",
     * maxMessage = "El nombre del puntaje no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombrepuntaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="puntajemin", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el puntaje minimo")
     */
    private $puntajemin;

    /**
     * @var integer
     *
     * @ORM\Column(name="puntajemax", type="integer", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el puntaje maximo")
     */
    private $puntajemax;

     /**
     *
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Formularioevaluacion", mappedBy="Puntajes")
    */
    private $idformulario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idformulario = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString() {
        return $this->nombrepuntaje;
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
     * Set nombrepuntaje
     *
     * @param string $nombrepuntaje
     * @return Puntaje
     */
    public function setNombrepuntaje($nombrepuntaje)
    {
        $this->nombrepuntaje = $nombrepuntaje;
    
        return $this;
    }

    /**
     * Get nombrepuntaje
     *
     * @return string 
     */
    public function getNombrepuntaje()
    {
        return $this->nombrepuntaje;
    }

    /**
     * Set puntajemin
     *
     * @param integer $puntajemin
     * @return Puntaje
     */
    public function setPuntajemin($puntajemin)
    {
        $this->puntajemin = $puntajemin;
    
        return $this;
    }

    /**
     * Get puntajemin
     *
     * @return integer 
     */
    public function getPuntajemin()
    {
        return $this->puntajemin;
    }

    /**
     * Set puntajemax
     *
     * @param integer $puntajemax
     * @return Puntaje
     */
    public function setPuntajemax($puntajemax)
    {
        $this->puntajemax = $puntajemax;
    
        return $this;
    }

    /**
     * Get puntajemax
     *
     * @return integer 
     */
    public function getPuntajemax()
    {
        return $this->puntajemax;
    }

    /**
     * Add idformulario
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario
     * @return Puntaje
     */
    public function addIdformulario(\SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario)
    {
        $idformulario->addPuntajes($this);
        $this->idformulario[] = $idformulario;
    
        return $this;
    }

    /**
     * Remove idformulario
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario
     */
    public function removeIdformulario(\SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion $idformulario)
    {
        $this->idformulario->removeElement($idformulario);
    }

    /**
     * Get idformulario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdformulario()
    {
        return $this->idformulario;
    }

/*   public function setIdformulario($formulario)
    {
        $this->Idformulario = $formulario;
        foreach ($puntajes as $puntaje) {
            $puntaje->setIdformulario($this);
        }
    }
*/

}