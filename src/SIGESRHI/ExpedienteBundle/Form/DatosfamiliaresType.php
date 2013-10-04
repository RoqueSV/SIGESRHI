<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosfamiliaresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parentesco', 'choice', array('label'=>'Parentesco ',
                'choices' => array('Padre' => 'Padre', 'Madre' => 'Madre', 'Esposa/o' => 'Esposa/o', 'Hijo/a' => 'Hijo/a'),'required'  => true,))
            ->add('nombrefamiliar',null, array('label'=>'Nombre '))
            ->add('direccionfamiliar',null, array('label'=>'Dirección '))
            ->add('telefonofamiliar',null, array('label'=>'Teléfono '))
            ->add('idsolicitudempleo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Datosfamiliares'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_datosfamiliarestype';
    }
}
