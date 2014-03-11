<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class PlancapacitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreplan',null,array(
                  'label'=>'Nombre plan',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('anoplan','choice', array(
                  'required' => true, 
                  'label'=>'Año a ejecutar plan',
                  'choices' => $this->buildYearChoices(),
                  'empty_value' => '',
                  'attr'=>array('class'=>'input-small')))
            ->add('objetivoplan','textarea',array(
                  'label'=>'Objetivo plan',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('descripcionplan','textarea',array(
                  'label'=>'Descripción plan',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('resultadosplan','textarea',array(
                  'label'=>'Resultados esperados',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
           /* ->add('tipoplan','choice', array(
                  'label'=>'Tipo plan',
                  'choices' => array(
                  'I' => 'Institucional', 'C' => 'Interno'),
                  'required'  => true, 
                  'empty_value' => 'Seleccione una opción')) 
            ->add('idcentro',null,array(
                  'label'=>'Centro de atención',
                  'required'=>false,
                  'query_builder' => function(EntityRepository $er) {
                                     return $er->createQueryBuilder('c')
                                     ->where('c.id <> 10')
                                     ->orderBy('c.nombrecentro', 'ASC');
                                     },
                  'empty_value' => 'Seleccione un centro',
                  'attr'=>array('class'=>'input-xmlarge'))) */
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Plancapacitacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_plancapacitaciontype';
    }

    public function buildYearChoices() {
    $distancebef = 0;
    $distanceaft = 2;
    $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distancebef));
    $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + $distanceaft));
    return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }
}