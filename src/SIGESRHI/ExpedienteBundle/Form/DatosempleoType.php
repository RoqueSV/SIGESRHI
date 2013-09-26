<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosempleoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreempresa',null, array('label'=>'Nombre de la Empresa'))
            ->add('direccionempresa',null, array('label'=>'Dirección de la Empresa'))
            ->add('telefonoempresa',null, array('label'=>'Teléfono de la Empresa'))
            ->add('fechainiciolaboral',null, array('label'=>'Fecha de Inicio Laboral', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('fechafinlaboral','date', array('label'=>'Fecha de Fin Laboral', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy','attr' => array('class' => 'date')))
            ->add('jefeinmediato',null, array('label'=>'Nombre del Jefe Inmediato'))
            ->add('cargodesempenado',null, array('label'=>'Cargo Desempeñado'))
            ->add('sueldo', null,array('label'=>'Sueldo'))
            ->add('motivoretiro',null, array('label'=>'Motivo del Retiro de la Empresa'))
            ->add('tipodatoempleo', 'text', array('label'=>'Tipo de Empleo', 'required'  => false, 'disabled'=>'disabled'))
            //->add('tipodatoempleo', 'choice', array('label'=>'Tipo de Empleo', 'choices' => array('actual' => 'Empleo Actual', 'anterior' => 'Empleo Anterior'),'required'  => false,))
            ->add('idsolicitudempleo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Datosempleo'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_datosempleotype';
    }
}
