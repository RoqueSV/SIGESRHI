<?php

namespace SIGESRHI\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocnoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombredocnoticia', null, array('label'=>'Nombre Archivo: ',))
            ->add('file', 'file', array('label'=>' Adjuntar Imagen o Archivo:', 'required'=>true))
            //->add('rutadocnoticia')
            //->add('idnoticia')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\Docnoticia'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_docnoticiatype';
    }
}
