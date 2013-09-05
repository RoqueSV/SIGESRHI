<?php

namespace SIGESRHI\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnidadorganizativaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder   
            ->add('nombreunidad',null,array('label'=>'Unidad organizativa'))
            ->add('descripcionunidad',null,array('label'=>'Descripcion'))
            ->add('idcentro',null,array('multiple'=>false,'label'=>'Centros'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\Unidadorganizativa'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_unidadorganizativatype';
    }
}
