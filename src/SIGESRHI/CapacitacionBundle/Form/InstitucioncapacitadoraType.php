<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstitucioncapacitadoraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreinstitucion',null,array(
                  'label'=>'Nombre institución',
                  'required'=>true,
                  'attr'=>array('class'=>'input-medium')))
            ->add('nombrecontacto',null,array(
                  'label'=>'Nombre contacto',
                  'attr'=>array('class'=>'input-medium')))
            ->add('telefonocontacto',null,array(
                  'label'=>'Teléfono',
                  'max_length'=>'8', 
                  'attr'=>array(
                  'class'=>'input-small telefono', 
                  'data-bvalidator'=>'phone')))
            ->add('cargocontacto',null,array(
                  'label'=>'Cargo contacto',
                  'attr'=>array(
                  'class'=>'input-xlarge'))) 
            ->add('emailcontacto',null,array(
                  'label'=>'Email', 
                  'attr'=>array(
                  'class'=>'input-xlarge', 
                  'data-bvalidator'=>'email,required')))

            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Institucioncapacitadora'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_institucioncapacitadoratype';
    }
}
