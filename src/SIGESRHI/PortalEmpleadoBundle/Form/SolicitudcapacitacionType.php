<?php

namespace SIGESRHI\PortalEmpleadoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudcapacitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechasolicitud')
            ->add('aprobacionsolicitud')
            ->add('motivosolicitud')
            ->add('comentariosolicitud')
            ->add('idcapacitacion')
            ->add('idempleado')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\PortalEmpleadoBundle\Entity\Solicitudcapacitacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_portalempleadobundle_solicitudcapacitaciontype';
    }
}
