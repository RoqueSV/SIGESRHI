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
            ->add('parentesco', 'choice', array('label'=>'Parentesco: ',
                'choices' => array('Padre' => 'Padre', 'Madre' => 'Madre', 'Esposa/o' => 'Esposa/o', 'Hijo/a' => 'Hijo/a'),'required'  => true,'empty_value' => 'Seleccione', 'attr'=>array('class'=>'input-small')))
            ->add('nombrefamiliar',null, array('label'=>'Nombre: ', 'attr'=>array('class' =>'input-large')))
            ->add('direccionfamiliar',null, array('label'=>'Dirección:  ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('telefonofamiliar',null, array('label'=>'Teléfono: ', 'max_length'=>'8', 'attr'=>array('class'=>'input-small telefono', 'data-bvalidator'=>'phone,required')))
           // ->add('idsolicitudempleo') 
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
