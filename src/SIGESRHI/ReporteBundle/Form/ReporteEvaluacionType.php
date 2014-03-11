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
            ->add('anoplan','choice', array(
                  'required' => true, 
                  'label'=>'Seleccione año',
                  'choices' => $this->buildYearChoices(),
                  'empty_value' => '',
                  'attr'=>array('class'=>'input-small')))
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
    $distancebef = 10;
    $distanceaft = 0;
    $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distancebef));
    $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + $distanceaft));
    return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }
}