<?php

namespace SIGESRHI\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CentrounidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrecentro')
            ->add('especialidad')
            ->add('direccioncentro')
            ->add('telefonocentro')
            ->add('extensioncentro')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\Centrounidad'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_centrounidadtype';
    }
}
