<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HojaservicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreempleado',null, array('label'=>'Nombre empleado'))
            ->add('dui',null,array('label'=>'DUI No.','attr'=>array('class'=>'input-small','readonly'=>true)))
            ->add('lugardui',null,array('label'=>'Extendido en ','attr'=>array('class'=>'input-medium','readonly'=>true)))
            ->add('lugarnac',null,array('label'=>'Lugar de nacimiento','attr'=>array('class'=>'input-medium')))
            ->add('fechanac', null, array(
                  'label'=>'Fecha', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy',
                  'attr' => array(
                  'class' => 'date input-small',
                  'data-bvalidator'=>'required', 
                  'readonly'=>true),))
            ->add('estadocivil', 'choice', array(
                  'label'=>'Estado civil ',
                  'choices' => array('S' => 'Soltero', 'A' => 'Acompañado', 'C' => 'Casado', 'D' => 'Divorciado', 'V' => 'Viudo'),
                  'required'  => true, 
                  'empty_value' => 'Seleccione una opción',
                  'attr' =>array('class'=> 'input-medium')))
            ->add('direccion')
            ->add('telefonofijo',null, array(
                  'label'=>'Teléfono', 
                  'max_length'=>'8', 
                  'attr'=>array(
                  'class'=>'input-small telefono', 
                  'data-bvalidator'=>'phone,required')))
            ->add('educacion',null,array('label'=>'Educación'))
            ->add('fechaingreso',null, array(
                  'label'=>'Fecha de ingreso', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array('class' => 'date input-small', 
                  'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('cargo','text', array(
                  'label'=> 'Cargo',
                  'required'=> true,
                  'attr' =>array(
                  'class'=> 'input-xmlarge',
                  'readonly'=>true)))
            ->add('sueldoinicial',null,array(
                  'label'=>'Sueldo inicial',
                  'attr'=>array(
                  'class'=>'input-small',
                  'readonly'=>true)))
            ->add('isss',null, array(
                  'label'=>'Número ISSS',
                  'attr'=>array(
                  'class'=>'input-medium',
                  'readonly'=>true)))
            ->add('nit',null,array(
                  'label'=>'NIT',
                  'attr'=>array(
                  'class'=>'input-medium',
                  'readonly'=>true)))
            ->add('destacadoen','text', array(
                  'label'=> 'Destacado en',
                  'required'=> true,
                  'attr' =>array(
                  'class'=> 'input-xmlarge',
                  'readonly'=>true)))
            ->add('informacionadicional',null,array(
                  'label'=>'Información adicional',
                  'attr'=>array(
                  'class'=>'input-xmlarge')))
            //->add('idexpediente')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Hojaservicio'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_hojaserviciotype';
    }
}
