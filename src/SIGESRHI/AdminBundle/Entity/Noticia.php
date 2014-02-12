<?php

namespace SIGESRHI\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ExecutionContextInterface;
/**
 * Noticia
 *
 * @ORM\Table(name="noticia")
 * @ORM\Entity
 * @GRID\Source(columns="id,asuntonoticia,fechanoticia,fechainicionoticia,fechafinnoticia",groups={"news"})
 * @GRID\Source(columns="id,asuntonoticia,fechanoticia,fechainicionoticia,fechafinnoticia,idcentro.id",groups={"news2"})
 * @Assert\Callback(methods={"fechasValidas"})
 */
class Noticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="noticia_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(filterable=false, groups={"news","news2"}, visible=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanoticia", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de la noticia")
     * @GRID\Column(align="center",type="date",title="Fecha de Registro",groups={"news","news2"},filter="input", inputType="datetime", format="Y-m-d",operators={"gte", "eq", "lte"}, defaultOperator="gte"))
     */
    private $fechanoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="asuntonoticia", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el asunto de la noticia")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El asunto de la noticia no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(align="center",title="Titulo",groups={"news","news2"},filter="input", inputType="text",operators={"like"}, operatorsVisible=false))
     */
    private $asuntonoticia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainicionoticia", type="date", nullable=false)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de inicio de la noticia")
     * @GRID\Column(filterable=false, groups={"news","news2"}, visible=false)
     */
    private $fechainicionoticia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafinnoticia", type="date", nullable=true)
     * @Assert\DateTime()
     * @Assert\NotNull(message="Debe ingresar la fecha de fin de la noticia")
     * @GRID\Column(filterable=false, groups={"news","news2"}, visible=false)
     */
    private $fechafinnoticia;

    /**
     * @var string
     *
     * @ORM\Column(name="contenidonoticia", type="string", length=1000, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el contenido de la noticia")
     * @Assert\Length(
     * max = "1000",
     * maxMessage = "El contenido de la noticia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $contenidonoticia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Centrounidad")
     * @ORM\JoinTable(name="centronoticia",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idnoticia", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idcentro", referencedColumnName="id")
     *   }
     * )
     * @GRID\Column(field="idcentro.id",filterable=false, groups={"news2"}, visible=false)
     */
    private $idcentro;

     /**
     * @var \Docnoticia
     *
     * @ORM\OneToMany(targetEntity="Docnoticia", mappedBy="idnoticia",cascade={"persist","remove"})
     * @Assert\Valid
     *
     */
    private $iddocnoticia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcentro = new \Doctrine\Common\Collections\ArrayCollection();
        $this->iddocnoticia = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /************************Validacion de las Fechas y horas*****************/
    public function fechasValidas(ExecutionContextInterface $context)
    {
        $fechainicionoticia = $this->getFechainicionoticia();
        $fechafinnoticia =  $this->getFechafinnoticia();
        if($fechafinnoticia!=''){
            if($fechainicionoticia > $fechafinnoticia){
                $context->addViolationAt('fechainicionoticia','Debe introducir Fechas Validas',array(),null);
            }
        }
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
     * Set fechanoticia
     *
     * @param \DateTime $fechanoticia
     * @return Noticia
     */
    public function setFechanoticia($fechanoticia)
    {
        $this->fechanoticia = $fechanoticia;
    
        return $this;
    }

    /**
     * Get fechanoticia
     *
     * @return \DateTime 
     */
    public function getFechanoticia()
    {
        return $this->fechanoticia;
    }

    /**
     * Set asuntonoticia
     *
     * @param string $asuntonoticia
     * @return Noticia
     */
    public function setAsuntonoticia($asuntonoticia)
    {
        $this->asuntonoticia = $asuntonoticia;
    
        return $this;
    }

    /**
     * Get asuntonoticia
     *
     * @return string 
     */
    public function getAsuntonoticia()
    {
        return $this->asuntonoticia;
    }

    /**
     * Set fechainicionoticia
     *
     * @param \DateTime $fechainicionoticia
     * @return Noticia
     */
    public function setFechainicionoticia($fechainicionoticia)
    {
        $this->fechainicionoticia = $fechainicionoticia;
    
        return $this;
    }

    /**
     * Get fechainicionoticia
     *
     * @return \DateTime 
     */
    public function getFechainicionoticia()
    {
        return $this->fechainicionoticia;
    }

    /**
     * Set fechafinnoticia
     *
     * @param \DateTime $fechafinnoticia
     * @return Noticia
     */
    public function setFechafinnoticia($fechafinnoticia)
    {
        $this->fechafinnoticia = $fechafinnoticia;
    
        return $this;
    }

    /**
     * Get fechafinnoticia
     *
     * @return \DateTime 
     */
    public function getFechafinnoticia()
    {
        return $this->fechafinnoticia;
    }

    /**
     * Set contenidonoticia
     *
     * @param string $contenidonoticia
     * @return Noticia
     */
    public function setContenidonoticia($contenidonoticia)
    {
        $this->contenidonoticia = $contenidonoticia;
    
        return $this;
    }

    /**
     * Get contenidonoticia
     *
     * @return string 
     */
    public function getContenidonoticia()
    {
        return $this->contenidonoticia;
    }

    /**
     * Add idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     * @return Noticia
     */
    public function addIdcentro(\SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro)
    {
        $this->idcentro[] = $idcentro;
    
        return $this;
    }

    /**
     * Remove idcentro
     *
     * @param \SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro
     */
    public function removeIdcentro(\SIGESRHI\AdminBundle\Entity\Centrounidad $idcentro)
    {
        $this->idcentro->removeElement($idcentro);
    }

    /**
     * Get idcentro
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcentro()
    {
        return $this->idcentro;
    }

    /**
     * Get iddocnoticia
     *
     * @return \SIGESRHI\AdminBundle\Entity\Docnoticia 
     */
    public function getIddocnoticia()
    {
        return $this->iddocnoticia;
    }

    public function setIddocnoticia(\Doctrine\Common\Collections\Collection $iddocnoticia)
    {
        $this->iddocnoticia = $iddocnoticia;
        foreach ($iddocnoticia as $docnoticia) {
            $docnoticia->setIdnoticia($this);
        }
    }
}