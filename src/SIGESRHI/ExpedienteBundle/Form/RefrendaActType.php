<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RefrendaActType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         // ->add('codigoempleado')
            ->add('partida',null,array(
                  'required' => true, 
                  'label'=>'Partida',
                  'attr'=>array('class'=>'spinner input-mini', 'readonly'=>true)))
            ->add('subpartida',null,array(
                  'required' => true, 
                  'label'=>'Subpartida',
                  'attr'=>array('class'=>'spinner input-mini', 'readonly'=>true)))
            ->add('sueldoactual','text',array(
                  'label'=>'Sueldo actual',  
                  'required'  => true,
                  'attr' => array('class' => 'input-small dinero', 'data-bvalidator'=>'required')))
            ->add('unidadpresupuestaria','choice', array(
                  'label'=>'Unidad presupuestaria',
                  'choices' => array(
                  'Dirección y Administración Institucional' => 'Dirección y Administración Institucional',
                  'Servicios Integrales en Salud' => 'Servicios Integrales en Salud'),
                  'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('lineapresupuestaria','choice', array(
                  'label'=>'Linea presupuestaria',
                  'choices' => array(
                  'Dirección y Administración' => 'Dirección y Administración',
                  'Rehabilitación Integral' => 'Rehabilitación Integral'),
                  'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('codigolp',null, array(
                  'label'=>'Código linea presupuestaria', 
                  'max_length'=>'16', 
                  'attr' =>array('placeholder'=>'Sin guiones', 
                  'class'=> 'input-medium', 
                  'data-bvalidator'=>'number')))
        //  ->add('nombreplaza')
            ->add('tipo','choice', array(
                  'label'=>'Tipo',
                  'choices' => array(
                  'ls' => 'Ley de salario',
                  'c' => 'Contrato'),
                  'required'  => true, 'empty_value' => 'Seleccione una opción'))
        //  ->add('idempleado')
            ->add('idplaza','genemu_jqueryselect2_entity', array(
                  'class' => 'AdminBundle:Plaza', 
                  'property' => 'nombreplaza',
                  'label'=>  'Nombre plaza',
                  'empty_value' => 'Seleccione la plaza',
                  'required'=> true,
                  'attr' =>array('class'=> 'input-xmlarge')
                  ))
           ->add('centro', 'entity', array(
                  'class' => 'AdminBundle:Centrounidad',
                  'query_builder' => function(EntityRepository $er) {
                   return $er->createQueryBuilder('c')
                             ->orderBy('c.nombrecentro', 'ASC');
                   },
                  'empty_value'=> 'Seleccione centro',
                  'required' => false,
                  'mapped'=>false,
                  'attr' => array('class' => 'input-xmlarge')))
            ->add('idunidad', 'shtumi_dependent_filtered_entity', array(
                  'label' => 'Unidad organizativa',
                  'entity_alias' => 'centro_unidad',
                  'empty_value'=> 'Seleccione unidad',
                  'parent_field'=>'centro',
                  'required' => true,
                  'attr' => array('class' => 'input-xmlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\RefrendaAct'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_refrendaacttype';
    }
}
