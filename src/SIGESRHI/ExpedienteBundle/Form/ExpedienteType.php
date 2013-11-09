<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpedienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaexpediente')
            ->add('tipoexpediente')
            ->add('Docs_expediente', 'collection', array('label'=>' ', 'type' => new DocexpedienteType(), 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false, ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Expediente'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_expedientetype';
    }
}
