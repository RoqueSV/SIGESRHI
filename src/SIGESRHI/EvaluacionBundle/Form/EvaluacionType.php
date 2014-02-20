<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecharealizacion', null, array('label'=>'Fecha de realización: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr'=>array('hidden'=>'hidden')))
            ->add('anoevaluado', null , array('label'=>'Año evaluado: '))
            ->add('semestre', null, array('label'=>'Semestre: '))
            ->add('puestoemp', null, array('label'=>'Identificador de puesto del empleado: '))
            ->add('puestojefe', null, array('label'=>'Identificador de puesto del jefe: '))
            ->add('idempleado', null, array('label'=>'Empleado Evaluado: '))
            ->add('idjefe', null, array('label'=>'Evaluador: '))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Evaluacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_evaluaciontype';
    }
}
