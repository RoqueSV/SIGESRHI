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
            ->add('observaciones','textarea',array(
                  'label'=>'Observaciones', 
                  'required'  => false,
                  'attr' => array('class' => 'input-xmlarge')))
            ->add('sueldoinicial','text',array(
                  'label'=>'Sueldo inicial',  
                  'required'  => true,
                  'attr' => array('class' => 'input-small dinero', 'data-bvalidator'=>'required')))
            ->add('horaslaborales',null, array(
                  'label'=>'Horas laborales',
                  'max_length'=>'2',
                  'attr' => array('class'=>'input-small', 'data-bvalidator'=>'number')))
            ->add('jornadalaboral','choice', array(
                  'label'=>'Jornada laboral',
                  'choices' => array(
                  'D' => 'Diurna', 'M' => 'Matutina', 'C' => 'Vespertina', 'N' => 'Nocturna'),
                  'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('fechainiciocontratacion',null, array(
                  'label'=>'Fecha de inicio laboral', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('doccontratacion','hidden')
            ->add('file', 'file', array('label'=>'Subir documento o imagen del nombramiento emitido por DGP', 'required'=>false))
            //->add('tipocontratacion')
            //->add('fechafinnom')
            ->add('fechaautorizacion',null, array(
                  'label'=>'Fecha de autorización', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('numoficio',null,array(
                  'label'=>'Número de oficio',
                  'attr' => array('class'=>'input-small')))
            ->add('fechafincontrato',null, array(
                  'label'=>'Fecha fin contrato', 
                  'widget' => 'single_text', 
                  'format'=>'dd-MM-yyyy', 
                  'attr' => array('class' => 'datenr input-small', 'data-bvalidator'=>'required', 'readonly'=>true))) 
            ->add('idplaza','genemu_jqueryselect2_entity', array(
                  'class' => 'AdminBundle:Plaza', 'label'=> 'Cargo nombrado',
                  'empty_value' => 'Seleccione una opción',
                  'required'=> true,
                  'attr' =>array('class'=> 'input-xmlarge')
            ))
            ->add('idunidad','genemu_jqueryselect2_entity', array(
                  'class' => 'AdminBundle:Unidadorganizativa', 'label'=> 'Destacado en',
                  'empty_value' => 'Seleccione una opción',
                  'required'=> true,
                  'attr' =>array('class'=> 'input-xmlarge')
            ))
            //->add('idempleado')
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
