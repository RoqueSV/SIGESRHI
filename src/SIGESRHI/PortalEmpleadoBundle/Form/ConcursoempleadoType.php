<?php

namespace SIGESRHI\PortalEmpleadoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConcursoempleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('fecharegistro')
            ->add('docconcurso','hidden')
           // ->add('idempleado')
            ->add('file', 'file', array(
                  'label'=>'Subir documentación', 
                  'required'=>true))
           //->add('idconcurso')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Empleadoconcurso'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_empleadoconcursotype';
    }
}