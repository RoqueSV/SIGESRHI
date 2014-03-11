<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConcursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigoconcurso',null,array(
                  'label'=>'Código concurso',
                  'attr'=>array('class'=>'input-small')))
            ->add('fechaapertura',null, array(
                  'label'=>'Fecha de apertura', 
                  'required'  => true,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy',
                  'attr' => array('class' => 'input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('fechacierre',null, array(
                  'label'=>'Fecha de cierre', 
                  'required'  => true,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy',
                  'attr' => array('class' => 'input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('idcentro', null, array(
                  'label'=>'Centro al que pertenece', 
                  'required' => true,
                  'empty_value' => 'Seleccione un centro',
                  'attr'=>array('class'=>'input-xmlarge')))
           /* ->add('numeroacta',null,array(
                  'label'=>'No de acta de concurso')) */
           // ->add('anoacta')
           // ->add('idempleado')
           // ->add('idplaza') 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Concurso'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_concursotype';
    }
}
