<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpDocumentoDigitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaexpediente',null, array('label'=>'Fecha de Creación', 'widget'=>'single_text', 'format'=>'dd-MM-yyyy', 'attr'=>array('class'=>'input-small', 'readonly'=>true)))
            ->add('tipoexpediente',null, array('label'=>'Tipo de Expediente'))
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
        return 'sigesrhi_expedientebundle_expdocumentodigitaltype';
    }
}