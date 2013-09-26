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
            ->add('nombreidioma',null, array('label'=>'Idioma: '))
            ->add('nivelescribe', 'choice', array('label'=>'Escribe', 
                'choices' => array('NO'=>'NO', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('nivelhabla', 'choice', array('label'=>'Habla', 
                'choices' => array('No'=>'NO', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('nivellee', 'choice', array('label'=>'Lee', 
                'choices' => array('NO'=>'NO', 'Básico' => 'Básico', 'Intermedio' => 'Intermedio', 'Avanzado'=>'Avanzado'), 'required'  => true, 'empty_value' => 'Seleccione una opción'))
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
