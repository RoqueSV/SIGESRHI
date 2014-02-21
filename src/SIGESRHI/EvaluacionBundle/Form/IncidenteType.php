<?php

namespace SIGESRHI\EvaluacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncidenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaincidente', null, array('label'=>'fecha del incidente: '))
            ->add('tipoincidente', null, array('label'=>'Incidente'))
            ->add('descripcionincidente',null, array('label'=>'Descripción'))
            //->add('idfactorevaluacion')
            //->add('idevaluacion')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\EvaluacionBundle\Entity\Incidente'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_evaluacionbundle_incidentetype';
    }
}
