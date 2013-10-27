<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PruebapsicologicaType extends AbstractType
{
    protected $expediente;
    public function __construct ($expediente)
    {
        $this->expediente = $expediente;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('resultadocoeficiente','choice',array(
                'choices' => array('superior'=>'Superior de 120 a 129','alto'=>'Promedio Alto de 110 a 119','normal'=>'Promedio normal de 90 a 110','bajo'=>'Nivel bajo-torpe de 80 a 89'),
                'expanded' => true,
                'label'=>'Coeficiente Intelectual (C.I.)',            
                ))
            ->add('calificacioncoeficiente',null,array('attr'=>array('class' => 'input-small'),'max_length'=>'3'))
            ->add('resultadoafectividad','choice',array(
                'choices' => array('estable'=>'Estable','promedio'=>'Promedio','inestable'=>'Inestable'),
                'expanded' => true,
                'label'=>'Afectividad',
                ))
            ->add('resultadorelaciones','choice',array(
                'choices' => array('alta'=>'Alta','media'=>'Media','baja'=>'Baja'),
                'expanded'=>true,
                'label'=>'Relaciones Interpersonales',
                ))
            ->add('resultadoautoreconocimiento','choice',array(
                'choices'=>array('alta'=>'Alta','media'=>'Media','baja'=>'Baja'),
                'expanded'=>true,
                'label'=>'Autoreconocimiento',
                ))
            ->add('resultadoseguridad','choice',array(
                'choices'=>array('alta'=>'Alta','media'=>'Media','baja'=>'Baja'),
                'expanded'=>true,
                'label'=>'Seguridad',
                ))
            ->add('idexpediente','hidden',array(
                'data' => $this->expediente,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Pruebapsicologica'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_pruebapsicologicatype';
    }
}
