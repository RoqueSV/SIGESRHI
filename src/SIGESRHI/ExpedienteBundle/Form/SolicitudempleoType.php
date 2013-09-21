<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudempleoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numsolicitud')
            ->add('apellidocasada', null, array('label'=>'Apellido de Casada '))
            ->add('primerapellido', null, array('label'=>'Primer Apellido '))
            ->add('segundoapellido', null, array('label'=>'Segundo Apellido '))
            ->add('nombres', null, array('label'=>'Nombres '))
            ->add('colonia', null, array('label'=>'Colonia '))
            ->add('calle', null, array('label'=>'Numero/Calle/Avenida '))
            ->add('estadocivil', 'choice', array('label'=>'Estado Civil ',
                'choices' => array('s' => 'Soltero', 'a' => 'Acompañado', 'c' => 'Casado', 'd' => 'Divorciado', 'v' => 'Viudo'),'required'  => false,))
            ->add('telefonofijo', null, array('label'=>'Teléfono Fijo '))
            ->add('telefonomovil', null, array('label'=>'Teléfono Móvil '))
            ->add('email', null, array('label'=>'Correo Electrónico '))
            ->add('lugarnac', null, array('label'=>'Lugar de Nac. '))
            ->add('fechanac', 'date', array('label'=>'Fecha de Nac. ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy')) 
            ->add('dui', null, array('label'=>'DUI'))
            ->add('lugardui', null, array('label'=>'Lugar donde se extendió el DUI: '))
            ->add('fechadui', null, array('label'=>'Fecha se extendió el DUI: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('nit', null, array('label'=>'No NIT '))
            ->add('isss', null, array('label'=>'No ISSS '))
            ->add('nup', null, array('label'=>'No NUP '))
            ->add('nip', null, array('label'=>'No NIP '))
            ->add('sexo', 'choice', array('label'=>'Sexo ',
                'choices' => array('m' => 'Masculino', 'f' => 'Femenino'),'required'  => true,))
            ->add('fotografia', 'file', array('label'=>' Subir Fotografía'))
            ->add('fecharegistro',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('fechamodificacion',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('idmunicipio',null,array('required' => true,'label'=>'Municipio' ))
            ->add('departamentos', 'entity', array('class' => 'ExpedienteBundle:Departamento', 'property_path'=>false))
            ->add('idplaza',null, array('required'=> true, 'label'=>'Plaza'))
            ->add('idexpediente');

            //agregamos un formulario de otra entidad (datos empleo)
            $builder->add('Dempleos', 'collection', array('type' => new DatosempleoType(),));
            $builder->add('Dfamiliares', 'collection', array('type' => new DatosfamiliaresType(),));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_solicitudempleotype';
    }
}
