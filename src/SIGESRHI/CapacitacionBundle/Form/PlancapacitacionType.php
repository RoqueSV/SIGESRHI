<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlancapacitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreplan')
            ->add('anoplan')
            ->add('objetivoplan')
            ->add('descripcionplan')
            ->add('resultadosplan')
            ->add('tipoplan')
            ->add('idcentro')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Plancapacitacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_plancapacitaciontype';
    }
}
