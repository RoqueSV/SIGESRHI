<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpcionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreopcion', null, array('label'=>'Opción: ', 'attr'=>array('class'=>'input-small')))
            ->add('descripcionopcion', 'textarea', array('label'=>'Descripción: ', 'attr'=>array('class'=>'input-xmlarge')))
            ->add('valoropcion', null, array('label'=>'Valor de la opción: ', 'attr'=>array('class'=>'input-small', 'data-bvalidator'=>'number')))
            //->add('idfactor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Opcion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_opciontype';
    }
}
