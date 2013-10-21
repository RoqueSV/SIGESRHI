<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdiomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreidioma',null, array('label'=>'Idioma: ', 'attr'=>array('class'=>'input-large')))
            ->add('nivelescribe', 'choice', array('label'=>'Nivel Escribe: ', 
                'choices' => array('No Aplica'=>'No Aplica', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione', 'attr'=>array('class'=>'input-medium')))
            ->add('nivelhabla', 'choice', array('label'=>'Nivel Habla: ', 
                'choices' => array('No Aplica'=>'No Aplica', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione','attr'=>array('class'=>'input-medium')))
            ->add('nivellee', 'choice', array('label'=>'Nivel Lee: ', 
                'choices' => array('No Aplica'=>'No Aplica', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione','attr'=>array('class'=>'input-medium')))
            //->add('idsolicitudempleo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Idioma'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_idiomatype';
    }
}
