<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConcursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigoconcurso')
            ->add('fechaapertura')
            ->add('fechacierre')
            ->add('numeroacta')
            ->add('anoacta')
            ->add('idempleado')
            ->add('idplaza')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Concurso'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_concursotype';
    }
}
