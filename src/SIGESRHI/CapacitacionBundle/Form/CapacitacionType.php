<?php

namespace SIGESRHI\CapacitacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CapacitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tematica',null,array(
                  'label'=>'Temática',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('fechacapacitacion', null, array(
                  'label'=>'Fecha de realización', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array(
                  'class' => 'input-small', 
                  'data-bvalidator'=>'required', 
                  'readonly'=>true))) 
            ->add('horainiciocapacitacion','time',array(
                  'label'=>'Hora inicio'))
            ->add('horafincapacitacion','time',array(
                  'label'=>'Hora fin'))
            ->add('lugarcapacitacion',null,array(
                  'label'=>'Lugar capacitación',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('areacapacitacion',null,array(
                  'label'=>'Area',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('objetivocapacitacion','textarea',array(
                  'label'=>'Objetivo',
                  'required'=>true,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('perfilcapacitacion','textarea',array(
                  'label'=>'Perfil del participante',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('cupo',null,array(
                  'label'=>'Cupo',
                  'required'=>false,
                  'attr'=>array('class'=>'input-mini','data-bvalidator'=>'number')))
            ->add('metodologia','textarea',array(
                  'label'=>'Metodología ',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('resultadoscapacitacion','textarea',array(
                  'label'=>'Resultados esperados',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            ->add('plazocapacitacion',null, array(
                  'label'=>'Plazo inscripción', 
                  'required'=>false,
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array(
                  'class' => 'input-small', 
                  'readonly'=>true))) 
            ->add('contactocapacitacion',null,array(
                  'label'=>'Contacto',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge')))
            ->add('materialcapacitacion','textarea',array(
                  'label'=>'Material de apoyo',
                  'required'=>false,
                  'attr'=>array('class'=>'input-xmlarge','rows'=>'3')))
            //->add('estadocapacitacion')
            //->add('justificacioncambios')
            //->add('idplan')
            ->add('idcapacitador',null,array(
                  'label'=>'Capacitador',
                  'required'=>true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\CapacitacionBundle\Entity\Capacitacion'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_capacitacionbundle_capacitaciontype';
    }
}
