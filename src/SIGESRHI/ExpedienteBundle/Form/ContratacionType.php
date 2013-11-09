<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContratacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observaciones')
            ->add('sueldoinicial')
            ->add('horaslaborales')
            ->add('jornadalaboral')
            ->add('fechainiciocontratacion')
            ->add('doccontratacion')
            ->add('informacionadicional')
            ->add('tipocontratacion')
            ->add('fechafinnom')
            ->add('fechaautorizacion')
            ->add('numoficio')
            ->add('fechafincontrato')
            ->add('idplaza')
            ->add('idunidad')
            ->add('idempleado')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Contratacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_contrataciontype';
    }
}
