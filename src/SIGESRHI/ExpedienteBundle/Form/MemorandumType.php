<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MemorandumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('correlativo')
            //->add('tipomemorandum')
            //->add('idconcurso')
        ->add('empleado','genemu_jqueryselect2_entity', array(
              'class' => 'ExpedienteBundle:Empleado', 
              'property' => 'nombreemp',
              'label'=>  'Para',
              'empty_value' => 'Seleccione un empleado',
              'required'=> true,
              'mapped'=>false,
              'attr' =>array('class'=> 'input-xlarge')
              ))
        ->add('cargo', null, array(
              'label'=>'Cargo', 
              'mapped'=>false,
              'attr'=>array('class'=>'input-xlarge')))
        ->add('atraves','genemu_jqueryselect2_entity', array(
              'class' => 'ExpedienteBundle:Empleado', 
              'property' => 'nombreemp',
              'label'=>  'A través de',
              'empty_value' => 'Seleccione un empleado',
              'mapped'=>false,
              'required'=>false,
              'attr' =>array('class'=> 'input-xlarge')
              ))
        ->add('cargoatraves', null, array(
              'label'=>'Cargo', 
              'mapped'=>false,
              'required'=>false,
              'attr'=>array('class'=>'input-xlarge')))
        ->add('asunto', null, array(
              'label'=>'Asunto', 
              'mapped'=>false,
              'attr'=>array('class'=>'input-xxlarge'))) 
        ->add('contenido','textarea', array(
              'label'=>'Contenido', 
              'mapped'=>false,
              'attr'=>array('class'=>'input-xxlarge','rows'=>'10'))) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Memorandum'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_memorandumtype';
    }
}
