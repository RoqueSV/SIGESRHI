<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactorevaluacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrefactor', null, array('label'=>'Nombre del Factor: ', 'attr'=>array('class'=>'input-xxlarge')))
            ->add('descripcionfactor', null, array('label'=>'Descripción: ', 'attr'=>array('class'=>'input-xxlarge')))
            //->add('idformulario')
        ;
        //agregamos un formulario de otra entidad (datos de Opciones)
            $builder->add('Opciones', 'collection', array('label'=>' ', 'type' => new OpcionType(), 'allow_add' => true, 'allow_delete' => true, 'prototype_name' => '_opciones_', 'by_reference' => false, 'options'=>array('cascade_validation' => true)));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Factorevaluacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_factorevaluaciontype';
    }
}
