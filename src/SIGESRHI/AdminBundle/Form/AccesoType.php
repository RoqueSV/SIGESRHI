<?php

namespace SIGESRHI\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccesoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrepagina',null,array('label'=>'Opción:', 'required'=>'required'))
            ->add('ruta',null,array('label'=>'Ruta:','required'=>'required'))
            ->add('idrol',null,array('label'=>'Rol:', 'multiple'=>false))
            ->add('idmodulo',null,array('label'=>'Modulo:'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\Acceso'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_accesotype';
    }
}
