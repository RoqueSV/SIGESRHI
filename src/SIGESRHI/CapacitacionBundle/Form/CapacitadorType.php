<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CapacitadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrecapacitador',null,array(
                  'label'=>'Nombre completo',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xlarge')))
            ->add('telefonocapacitador',null,array(
                  'label'=>'Teléfono',
                  'max_length'=>'8', 
                  'attr'=>array(
                  'class'=>'input-small telefono', 
                  'data-bvalidator'=>'phone')))
            ->add('correocapacitador',null,array(
                  'label'=>'Email', 
                  'attr'=>array(
                  'class'=>'input-xlarge', 
                  'data-bvalidator'=>'email,required')))
            ->add('tematicacapacitador',null,array(
                  'label'=>'Temática que expone',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xlarge')))
            ->add('idinstitucion',null,array(
                  'label'=>'Institución a la que pertenece',
                  'required'=>true,
                  'empty_value'=>'Seleccione',
                  'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Capacitador'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_capacitadortype';
    }
}
