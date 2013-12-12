<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LicenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('concepto')
            ->add('duraciondias')
            ->add('duracionhoras')
            ->add('duracionminutos')
            ->add('congoce')
            ->add('fechainiciolic')
            ->add('fechafinlic')
            ->add('horainiciolic')
            ->add('horafinlic')
            ->add('fechapermiso')
            ->add('idexpediente')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Licencia'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_licenciatype';
    }
}
