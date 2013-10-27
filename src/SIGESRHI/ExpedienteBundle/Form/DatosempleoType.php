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
            ->add('nombreempresa',null, array('label'=>'Nombre de la Empresa: ', 'attr' => array('class' => 'input-xlarge')))
            ->add('direccionempresa', 'textarea', array('label'=>'Dirección de la Empresa: ',  'attr' => array('class' => 'input-xlarge')))
            ->add('telefonoempresa',null, array('label'=>'Teléfono de la Empresa: ',  'attr' => array('class' => 'input-small telefono', 'data-bvalidator'=>'phone, required')))
            ->add('fechainiciolaboral', 'date', array('label'=>'Fecha de Inicio Laboral: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy','attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true, 'required'=>true )))
            ->add('fechafinlaboral','date', array('label'=>'Fecha de Fin Laboral: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy','attr' => array('class' => 'date input-small', 'readonly'=>true)))
            ->add('jefeinmediato',null, array('label'=>'Nombre del Jefe Inmediato: ',  'attr' => array('class' => 'input-xlarge')))
            ->add('cargodesempenado',null, array('label'=>'Cargo Desempeñado: ', 'attr' => array('class' => 'input-xlarge')))
            ->add('sueldo', null,array('label'=>'Sueldo: ',  'attr' => array('class' => 'input-small dinero', 'data-bvalidator'=>'number,required')))
            ->add('motivoretiro','textarea', array('label'=>'Motivo del Retiro de la Empresa: ', 'attr' => array('class' => 'input-xlarge')))
            //->add('tipodatoempleo', 'text', array('label'=>'Tipo de Empleo', 'required'  => false, 'attr'=>array('readonly'=>true)))
            ->add('tipodatoempleo', 'choice', array('label'=>'Tipo de Empleo', 'choices' => array('Empleo Actual' => 'Empleo Actual', 'Empleo Anterior' => 'Empleo Anterior'),'required'  => true, 'empty_value' => 'Seleccione una opción',))
            //->add('idsolicitudempleo')
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
