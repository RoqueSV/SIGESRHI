<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormularioevaluacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoformulario', null, array('label'=>'Título del formulario: ', 'attr'=>array('class'=>'input-xxlarge')))
            ->add('codigoformulario', null, array('label'=>'Código de formulario: ', 'attr'=>array('class'=>'input-small')))
            ->add('nombrebreve', null, array('label'=>'Nombre del tipo de personal a evaluar: ', 'attr'=>array('class'=>'input-xmlarge')))
            //->add('estadoform',null, array('label'=>'Estado del Formulario'))
            //->add('Puntajes', null, array('label'=>'Seleccione los puntajes aplicables: '))
        ;

   }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Formularioevaluacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_formularioevaluaciontype';
    }
}
