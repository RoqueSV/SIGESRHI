<?php

namespace SIGESRHI\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Empleado
 *
 * @ORM\Table(name="hojaservicio")
 * @ORM\Entity
 * @Assert\Callback(methods={"esDuiValido"})
 * @Assert\Callback(methods={"esNitValido"})
 */
class Hojaservicio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="empleado_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreempleado", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre del empleado")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre del empleado no debe exceder los {{limit}} caracteres"
     * )
     */
    private $nombreempleado;

    /**
     * @var string
     *
     * @ORM\Column(name="dui", type="string", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el DUI")
     * @Assert\Length(
     * max = "10",
     * maxMessage = "El DUI no debe exceder los {{limit}} caracteres"
     * )
     *
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="lugardui", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el lugar de emision del DUI")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El lugar de emision del DUI no debe exceder los {{limit}} caracteres"
     * )
     *
     */
    private $lugardui;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lugarnac", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el lugar de nacimiento")
     * @Assert\Length(
     * max = "50",
     * maxMessage = "El lugar de nacimiento no debe exceder los {{limit}} caracteres"
     * )
     *
     */
    private $lugarnac;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanac", type="date", nullable=false)
     * 
     */
    private $fechanac;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocivil", type="string", length=12, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el estado civil")
     * @Assert\Length(
     * max = "12",
     * maxMessage = "El estado civil no debe exceder los {{limit}} caracteres"
     * )
     */
    private $estadocivil;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=200, nullable=false)
     * @Assert\NotNull(message="Debe ingresar la dirección")
     * @Assert\Length(
     * max = "200",
     * maxMessage = "La colonia no debe exceder los {{limit}} caracteres"
     * )
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="educacion", type="string", length=150, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de un titulo")
     * @Assert\Length(
     * max = "150",
     * maxMessage = "El nombre del titulo no debe exceder los {{limit}} caracteres"
     * )
     */
    private $educacion;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaingreso", type="date", nullable=false)
     * 
     */
    private $fechaingreso;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=100, nullable=false)
     * @Assert\NotNull(message="Debe ingresar el nombre de la plaza")
     * @Assert\Length(
     * max = "100",
     * maxMessage = "El nombre de la plaza no debe exceder los {{limit}} caracteres"
     * )
     */
    private $cargo;


    /**
     * @var float
     *
     * @ORM\Column(name="sueldoinicial", type="float", nullable=false)
     * @Assert\NotNull(message="Debe ingresar el sueldo inicial")
     */
    private $sueldoinicial;

    /**
     * @var string
     *
     * @ORM\Column(name="isss", type="string", length=9, nullable=true)
     * @Assert\Length(
     * max = "9",
     * maxMessage = "El N° ISSS no debe exceder los {{limit}} caracteres"
     *)
     */
    private $isss;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=14, nullable=false)
     * @Assert\Length(
     * max = "14",
     * maxMessage = "El NIT no debe exceder los {{limit}} caracteres"
     *)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="destacadoen", type="text", length=100, nullable=true)
     * @Assert\Length(
     * max = "100",
     * maxMessage = "La informacion adicional no debe exceder los {{limit}} caracteres"
     * )
     */
    private $destacadoen;

    /**
     * @var string
     *
     * @ORM\Column(name="informacionadicional", type="text", length=500, nullable=true)
     * @Assert\Length(
     * max = "500",
     * maxMessage = "La informacion adicional no debe exceder los {{limit}} caracteres"
     * )
     */
    private $informacionadicional;

    
    /**
     * @var \Expediente
     *
     * @ORM\OneToOne(targetEntity="Expediente", inversedBy="hojaservicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idexpediente", referencedColumnName="id")
     * })
     */
    private $idexpediente;


    public function __toString() {
          return $this->codigoempleado;
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
     * Set nombreempleado
     *
     * @param string $nombreempleado
     * @return Hojaservicio
     */
    public function setNombreempleado($nombreempleado)
    {
        $this->nombreempleado = $nombreempleado;
    
        return $this;
    }

    /**
     * Get nombreempleado
     *
     * @return string 
     */
    public function getNombreempleado()
    {
        return $this->nombreempleado;
    }

    /**
     * Set dui
     *
     * @param string $dui
     * @return Hojaservicio
     */
    public function setDui($dui)
    {
        $this->dui = $dui;
    
        return $this;
    }

    /**
     * Get dui
     *
     * @return string 
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set lugardui
     *
     * @param string $lugardui
     * @return Hojaservicio
     */
    public function setLugardui($lugardui)
    {
        $this->lugardui = $lugardui;
    
        return $this;
    }

    /**
     * Get lugardui
     *
     * @return string 
     */
    public function getLugardui()
    {
        return $this->lugardui;
    }

    /**
     * Set lugarnac
     *
     * @param string $lugarnac
     * @return Hojaservicio
     */
    public function setLugarnac($lugarnac)
    {
        $this->lugarnac = $lugarnac;
    
        return $this;
    }

    /**
     * Get lugarnac
     *
     * @return string 
     */
    public function getLugarnac()
    {
        return $this->lugarnac;
    }

    /**
     * Set fechanac
     *
     * @param \DateTime $fechanac
     * @return Hojaservicio
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;
    
        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime 
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Set estadocivil
     *
     * @param string $estadocivil
     * @return Hojaservicio
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;
    
        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return string 
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Hojaservicio
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set educacion
     *
     * @param string $educacion
     * @return Hojaservicio
     */
    public function setEducacion($educacion)
    {
        $this->educacion = $educacion;
    
        return $this;
    }

    /**
     * Get educacion
     *
     * @return string 
     */
    public function getEducacion()
    {
        return $this->educacion;
    }

    /**
     * Set fechaingreso
     *
     * @param \DateTime $fechaingreso
     * @return Hojaservicio
     */
    public function setFechaingreso($fechaingreso)
    {
        $this->fechaingreso = $fechaingreso;
    
        return $this;
    }

    /**
     * Get fechaingreso
     *
     * @return \DateTime 
     */
    public function getFechaingreso()
    {
        return $this->fechaingreso;
    }

    /**
     * Set cargo
     *
     * @param string $direccion
     * @return Hojaservicio
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set sueldoinicial
     *
     * @param float $sueldoinicial
     * @return Hojaservicio
     */
    public function setSueldoinicial($sueldoinicial)
    {
        $this->sueldoinicial = $sueldoinicial;
    
        return $this;
    }

    /**
     * Get sueldoinicial
     *
     * @return float 
     */
    public function getSueldoinicial()
    {
        return $this->sueldoinicial;
    }

    /**
     * Set isss
     *
     * @param string $isss
     * @return Hojaservicio
     */
    public function setIsss($isss)
    {
        $this->isss = $isss;
    
        return $this;
    }

    /**
     * Get isss
     *
     * @return string 
     */
    public function getIsss()
    {
        return $this->isss;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Hojaservicio
     */
    public function setNit($nit)
    {
        $this->nit = $nit;
    
        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set destacadoen
     *
     * @param string $destacadoen
     * @return Hojaservicio
     */
    public function setDestacadoen($destacadoen)
    {
        $this->destacadoen = $destacadoen;
    
        return $this;
    }

    /**
     * Get destacadoen
     *
     * @return string 
     */
    public function getDestacadoen()
    {
        return $this->destacadoen;
    }

    /**
     * Set informacionadicional
     *
     * @param string $informacionadicional
     * @return Hojaservicio
     */
    public function setInformacionadicional($informacionadicional)
    {
        $this->informacionadicional = $informacionadicional;
    
        return $this;
    }

    /**
     * Get informacionadicional
     *
     * @return string 
     */
    public function getInformacionadicional()
    {
        return $this->informacionadicional;
    }

    /**
     * Set idexpediente
     *
     * @param \SIGESRHI\ExpedienteBundle\Entity\Expediente $idexpediente
     * @return Hojaservicio
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


    /******************** Validacion del dui y nit ******************/


    
        public function esDuiValido(ExecutionContextInterface $context)
            {
           
            $pDui = $this->getDui();


        $i= 0;
        $suma = 0;
        $digito = 0;

        if($pDui == '000000000'||$pDui=='' || strlen($pDui) != 9){

            $context->addViolationAt('dui', 'El DUI introducido no tiene
                el formato correcto (9 digitos), sin guiones y
                sin dejar ningún espacio en blanco)', array(), null);
                return;

        }
                

        $digito = substr($pDui,8);

        for($i=1;$i<strlen($pDui);$i++){
                $suma = $suma + ((substr($pDui,$i-1,1))*(10-$i));
                //echo "$suma<br>";
        }//fin for

        $validar = 0;
        $validar = (10-($suma%10)) % 10;
        //echo "<br><br>".$validar."==".$digito."<br><br>";
       
        if($digito != $validar){

            $context->addViolationAt('dui', 'DUI ingresado Inválido.',array(), null);

        }//fin if

    
            }//fin funcion esDuiValido()



    //Funcion validar NIT

            
    public function esNitValido(ExecutionContextInterface $context){

    $nit= $this->getNit();

    if(preg_match('/(^\d{14})/',$nit)){
        $verificador = (int) substr($nit,13,1);
        $valida = false;
        $suma = 0;
        if(( (int)substr($nit,10,3) ) <= 100){
            for($i = 1; $i <= 13; $i++){
                $suma += ( (int) substr($nit,( $i - 1 ),1) ) * ( 15 - $i );
            }
            $valida = ($suma%11);

            if($valida == 10){
                $valida = 0;
            }
        }else{
            for($i = 1; $i <= 13; $i++){
                $factor = (3 + (6 * floor(abs(( $i + 4 ) / 6)))) - $i;
                $suma += ( (int) substr($nit,( $i - 1 ),1) ) * $factor;
            }
            $mod = ($suma%11);
            if($mod > 1){
                $valida = 11 - $mod;
            }else{
                $valida = 0;
            }
        }
        if($valida != $verificador) 
             $context->addViolationAt('nit', 'El NIT introducido no es válido.', array(), null);
            
   }
   else{
    $context->addViolationAt('nit', 'NIT no tiene el formato correcto (14 digitos), sin guiones y
                sin dejar ningún espacio en blanco)', array(), null);
    }

}//fin validar NIT

/****************************************************************/

}