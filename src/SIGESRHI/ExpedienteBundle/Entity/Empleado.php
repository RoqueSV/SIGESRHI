<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado")
 * @ORM\Entity
 * @GRID\Source(columns="id , codigoempleado, idexpediente.idsolicitudempleo.nombrecompleto, idrefrenda.idplaza.nombreplaza,idrefrenda.id, idrefrenda.puestoempleado.puestojefe.id, idevaluacion.semestre, idevaluacion.anoevaluado", groups={"grupo_empleados_a_evaluar"})
 */
class Empleado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="empleado_id_seq", allocationSize=1, initialValue=1)
     * @GRID\Column(field="id", groups={"grupo_empleados_a_evaluar"},visible=false, filterable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoempleado", type="string", length=5, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el codigo del empleado")
     * @Assert\Length(
     * max = "5",
     * maxMessage = "El codigo de empleado no debe exceder los {{limit}} caracteres"
     * )
     * @GRID\Column(field="codigoempleado", groups={"grupo_empleados_a_evaluar"},visible=true, filterable=false, title="Código")
     */
    private $codigoempleado;

    /**
     * @var \Expediente
     *
     * @ORM\OneToOne(targetEntity="Expediente", inversedBy="idempleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     * @GRID\Column(field="idexpediente.idsolicitudempleo.nombrecompleto", groups={"grupo_empleados_a_evaluar"},visible=true, joinType="inner", filterable=false, title="Nombre")
     */
    private $idexpediente;

    /**
     * @var \Usuario
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $idusuario;

    /**
     * @ORM\OneToMany(targetEntity="Contratacion", mappedBy="idempleado")
     * @GRID\Column(field="idcontratacion.puestojefe.id", groups={"grupo_empleados_a_evaluar"}, visible=true, joinType="inner", filterable=false, title="idjefe (contratacion)")
     */
    private $idcontratacion;

    /**
     * @ORM\OneToMany(targetEntity="\SIGESRHI\AdminBundle\Entity\RefrendaAct", mappedBy="idempleado")
     * @GRID\Column(field="idrefrenda.puestoempleado.puestojefe.id", groups={"grupo_empleados_a_evaluar"}, visible=false, joinType="inner", filterable=false, title="idjefe (refrenda)")
     * @GRID\Column(field="idrefrenda.idplaza.nombreplaza", groups={"grupo_empleados_a_evaluar"}, visible=true, joinType="inner", filterable=false, title="Puesto")
     * @GRID\Column(field="idrefrenda.id", groups={"grupo_empleados_a_evaluar"}, visible=false, joinType="inner", filterable=false, title="Idpuesto")
     */
    private $idrefrenda;

    /**
     * @ORM\OneToMany(targetEntity="Empleadoconcurso", mappedBy="idempleado")
     */
    private $idempleadoconcurso;

    /**
     * @ORM\OneToMany(targetEntity="\SIGESRHI\EvaluacionBundle\Entity\Evaluacion", mappedBy="idempleado")
     * @GRID\Column(field="idevaluacion.semestre", groups={"grupo_empleados_a_evaluar"}, visible=false, joinType="left", filterable=false, title="Semestre")
     * @GRID\Column(field="idevaluacion.anoevaluado", groups={"grupo_empleados_a_evaluar"}, visible=false, joinType="left", filterable=false, title="Año")
     */
    private $idevaluacion;

    public function __toString() {
        return $this->codigoempleado;
       }   

    public function getNombreemp() {
        return $this->getIdexpediente()->getIdsolicitudempleo()->getNombrecompleto();
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
     * Set codigoempleado
     *
     * @param string $codigoempleado
     * @return Empleado
     */
    public function setCodigoempleado($codigoempleado)
    {
        $this->codigoempleado = $codigoempleado;
    
        return $this;
    }

    /**
     * Get codigoempleado
     *
     * @return string 
     */
    public function getCodigoempleado()
    {
        return $this->codigoempleado;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Empleado
     */
    public function setIdexpediente(\SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente = null)
    {
        $this->idexpediente = $idexpediente;
    
        return $this;
    }

    /**
     * Get idexpediente
     *
     * @return \SIGESRHI\ExpedienteBundle\Entity\Expediente 
     */
    public function getIdexpediente()
    {
        return $this->idexpediente;
    }

    /**
     * Set idusuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuario
     * @return Empleado
     */
    public function setIdusuario(\Application\Sonata\UserBundle\Entity\User $idusuario = null)
    {
        $this->idusuario = $idusuario;
    
        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcontratacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idrefrenda = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idempleadoconcurso = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idevaluacion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     * @return Empleado
     */
    public function addIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion[] = $idcontratacion;
    
        return $this;
    }

    /**
     * Remove idcontratacion
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion
     */
    public function removeIdcontratacion(\SIGESRHI\ExpedienteBundle\Entity\Contratacion $idcontratacion)
    {
        $this->idcontratacion->removeElement($idcontratacion);
    }

    /**
     * Get idcontratacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcontratacion()
    {
        return $this->idcontratacion;
    }


    /**
     * Add idrefrenda
     *
     * @param \SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda
     * @return Empleado
     */
    public function addIdrefrenda(\SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda)
    {
        $this->idrefrenda[] = $idrefrenda;
    
        return $this;
    }

    /**
     * Remove idrefrenda
     *
     * @param \SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda
     */
    public function removeIdrefrenda(\SIGESRHI\AdminBundle\Entity\RefrendaAct $idrefrenda)
    {
        $this->idrefrenda->removeElement($idrefrenda);
    }

    /**
     * Get idrefrenda
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdrefrenda()
    {
        return $this->idrefrenda;
    }

    /**
     * Add idempleadoconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso
     * @return Empleado
     */
    public function addIdempleadoconcurso(\SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso)
    {
        $this->idempleadoconcurso[] = $idempleadoconcurso;
    
        return $this;
    }

    /**
     * Remove idempleadoconcurso
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso
     */
    public function removeIdempleadoconcurso(\SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso $idempleadoconcurso)
    {
        $this->idempleadoconcurso->removeElement($idempleadoconcurso);
    }

    /**
     * Get idempleadoconcurso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdempleadoconcurso()
    {
        return $this->idempleadoconcurso;
    }


    /**
     * Add idevaluacion
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion
     * @return Evaluacion
     */
    public function addIdevaluacion(\SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion)
    {
        $this->idevaluacion[] = $idevaluacion;
    
        return $this;
    }

    /**
     * Remove Evaluacion
     *
     * @param \SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion
     */
    public function removeIdevaluacion(\SIGESRHI\EvaluacionBundle\Entity\Evaluacion $idevaluacion)
    {
        $this->idevaluacion->removeElement($idevaluacion);
    }

    /**
     * Get idevaluacion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdevaluacion()
    {
        return $this->idevaluacion;
    }
}