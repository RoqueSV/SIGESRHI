<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CapacitacionmodificadaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tematicamodificada',null,array(
                  'label'=>'Temática',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('fechamodificada',null, array(
                  'label'=>'Fecha de realización', 
                  'required' => false,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array(
                  'class' => 'date input-small', 
                  'data-bvalidator'=>'required', 
                  'readonly'=>true))) 
            ->add('horainiciomodificada','time',array(
                  'label'=>'Hora inicio'))
            ->add('horafinmodificada','time',array(
                  'label'=>'Hora fin'))
            ->add('lugarmodificado',null,array(
                  'label'=>'Lugar capacitación',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('perfilmodificado','textarea',array(
                  'label'=>'Perfil del participante',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('cupomodificado',null,array(
                  'label'=>'Cupo',
                  'required'=>false,
                  'attr'=>array('class'=>'input-mini','data-bvalidator'=>'number')))
            ->add('metodologiamodificada','textarea',array(
                  'label'=>'Metodología ',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('resultadosmodificados','textarea',array(
                  'label'=>'Resultados esperados',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('plazomodificado',null, array(
                  'label'=>'Plazo inscripción', 
                  'required'=>false,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array(
                  'class' => 'date input-small', 
                  'readonly'=>true))) 
            ->add('contactomodificado',null,array(
                  'label'=>'Contacto',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('materialmodificado','textarea',array(
                  'label'=>'Material de apoyo',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('justificacionmodificacion','textarea',array(
                  'label'=>'Motivo',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
          //  ->add('idcapacitacion')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Capacitacionmodificada'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_capacitacionmodificadatype';
    }
}
