<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpleadoconcursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecharegistro',null, array(
                  'label'=>'Fecha aplicación', 
                  'required'  => true,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy',
                  'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('docconcurso','hidden')
            ->add('idempleado','genemu_jqueryselect2_entity', array(
                  'class' => 'ExpedienteBundle:Empleado', 
                  'property' => 'nombreemp',
                  'label'=>  'Nombre empleado',
                  'empty_value' => 'Seleccione un empleado',
                  'required'=> true,
                  'attr' =>array('class'=> 'input-xmlarge')
                  ))
            ->add('file', 'file', array(
                  'label'=>'Subir curriculum de empleado', 
                  'required'=>false))
           // ->add('idconcurso')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_empleadoconcursotype';
    }
}
