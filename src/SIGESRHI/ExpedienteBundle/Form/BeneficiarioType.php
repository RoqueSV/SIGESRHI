<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BeneficiarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrebeneficiario',null, array('label' => 'Nombres y apellidos: ', 'attr'=>array('class' => 'input-large', 'data-bvalidator'=>'alpha')))
            ->add('parentescobeneficiario',null, array('label' => 'Parentesco: ', 'attr'=>array('class' => 'input-large', 'data-bvalidator'=>'alpha')))
            ->add('porcentaje',null, array('label' => '%', 'attr'=>array('class' => 'input-small', 'data-bvalidator'=>'between[1:100]')))
            //->add('idsegurovida')
           ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Beneficiario'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_beneficiariotype';
    }
}
