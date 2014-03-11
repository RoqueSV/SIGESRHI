<?php

namespace SIGESRHI\ReporteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('empleado','genemu_jqueryselect2_entity', array(
              'class' => 'ExpedienteBundle:Empleado', 
              'property' => 'nombreemp',
              'label'=>  'Seleccione un empleado',
              'empty_value' => 'Seleccione un empleado',
              'required'=> true,
              'mapped'=>false,
              'attr' =>array('class'=> 'input-xlarge')
              ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Empleado'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_reportetype';
    }
}