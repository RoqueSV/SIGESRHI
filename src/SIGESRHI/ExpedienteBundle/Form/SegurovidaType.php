<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SegurovidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaseguro', 'hidden', array('label'=>'Fecha de Nac.')) 
            ->add('estadoseguro',null, array('label'=>'Estado', 'attr'=>array('data-bvalidator'=>'phone,required','class'=>'telefono')))
            ->add('idexpediente',null,array('label'=>'Expediente', ))
            ->add('idbeneficiario', 'collection', array(
                'type' => new BeneficiarioType(),
                'label' => ' ',
                'by_reference' => false,
                'allow_add' => true, 
                'allow_delete' => true,

                )) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Segurovida'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_segurovidatype';
    }
}
