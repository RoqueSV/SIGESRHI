<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PeriodoevalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechainicio', null, array('label'=>'Fecha de inicio: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true),) ) 
            ->add('fechafin', null, array('label'=>'Fecha de finalización: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true),) ) 
            ->add('semestre', 'choice', array('label'=>'Seleccione el semestre: ', 'choices'=>array('I'=>'Primer Semestre', 'II'=>'Segundo Semestre'),'required'  => true, 'empty_value' => 'Seleccione una opción'))
            //->add('anio', null, array('label'=>'Año de evaluación: '))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Periodoeval'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_periodoevaltype';
    }
}
