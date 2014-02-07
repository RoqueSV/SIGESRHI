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
            ->add('nombreopcion', null, array('label'=>'Opcion: '))
            ->add('descripcionopcion', null, array('label'=>'Descripción: '))
            ->add('valoropcion', null, array('label'=>'Valor de la opción: '))
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
