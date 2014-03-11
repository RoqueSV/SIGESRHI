<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PuntajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrepuntaje',null, array('label'=>'Nombre: ', 'attr'=>array('class'=>'input-medium')))
            ->add('puntajemin','number', array('label'=>'Puntaje Mínimo: ', 'attr'=>array('class'=>'input-small spinner', 'readonly'=>true)))
            ->add('puntajemax', 'number', array('label'=>'Puntaje Máximo: ', 'attr'=>array('class'=>'input-small spinner', 'readonly'=>true)))
            ->add('nombreabreviado', null, array('label'=>'Nombre Abreviado: ', 'attr'=>array('class'=>'input-small')))
            ->add('pescalafon', 'number', array('label'=>'% de escalafón ', 'attr'=>array('class'=>'input-small spinner', 'readonly'=>true)))
           // ->add('idformulario',null, array('label'=>'Formularios donde aplica el puntaje: ', 'multiple'=>true, expanded'=>true))
           /* ->add('idformulario','entity', array(
                    'class' => 'EvaluacionBundle:Formularioevaluacion',
                    'property' => 'tipoformulario',
                    'label'=>'Formularios donde aplica el puntaje: ', 
                    'multiple'=>true, 
                    'expanded'=>true))
                    */
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Puntaje'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_puntajetype';
    }
}
