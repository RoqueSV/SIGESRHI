<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocpersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombredocpersonal','text',array(
                'label' => 'Nombre del documento',
                'attr'=>array('class' => 'input-xlarge',
                                'data-bvalidator'=>'alphanum'
                )))
            //->add('entregado')
            ->add('indice','text',array(
                'label' => 'N° Correlativo',
                'attr'=>array('class' => 'input-small',
                              'data-bvalidator'=>'number'
                )))
            //->add('idexpediente')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Docpersonal'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_docpersonaltype';
    }
}
