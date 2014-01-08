<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LicenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('concepto','choice',array(
                'choices' => array('Enfermedad'=>'Enfermedad','Personal'=>'Personal','Mision'=>'Mision Oficial'),
                'expanded' => true,
                'label' => 'Motivos',
                ))
            ->add('duraciondias',null,array(
                'label' => 'Número de días',
                'attr' => array('class'=> 'input-small', 'data-bvalidator'=>'number,required','maxlength'=>'2','minlength'=>'1','readonly'=>true)
                ))
            ->add('duracionhoras',null,array(
                'label' => 'Número de horas',
                'attr' => array('class'=> 'input-small', 'data-bvalidator'=>'number','maxlength'=>'2','minlength'=>'1','readonly'=>true)
                ))
            ->add('duracionminutos',null,array(
                'label' => 'Número de minutos',
                'attr' => array('class'=> 'input-small', 'data-bvalidator'=>'number','maxlength'=>'2','minlength'=>'0','readonly'=>true)
                ))
            ->add('congoce','choice',array(
                'choices' => array('1'=>'Con goce de Sueldo','0'=>'Sin goce de Sueldo'),                
                'expanded' => true,
                'label' => 'Permiso',

                ))
            ->add('fechainiciolic','date',array(
                'label' => 'Fecha de Incio',
                'widget' => 'single_text', 
                'format'=>'dd-MM-yyyy',
                'attr' => array('class' => 'date2 input-small', 'data-bvalidator'=>'required', 'readonly'=>true),
                ))
            ->add('fechafinlic','date',array(
                'label' => 'Fecha Fin',
                'widget' => 'single_text', 
                'format'=>'dd-MM-yyyy',
                'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true),
                ))
            ->add('horainiciolic','time',array(
                'label' => 'Hora de salida',
                ))
            ->add('horafinlic','time',array(
                'label' => 'Hora de regreso',
                ))
            /*->add('fechapermiso','date',array(
                'label' => 'Fecha Registro',
                'widget' => 'single_text', 
                'format'=>'dd-MM-yyyy',
                'attr' => array('class' => 'input-medium', 'data-bvalidator'=>'required', 'readonly'=>true),
                ))*/
            //->add('idcontratacion')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Licencia'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_licenciatype';
    }
}
