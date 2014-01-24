<?php

namespace SIGESRHI\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder        
            ->add('asuntonoticia','text',array(
                'label'=>'Titulo',
                'attr'=>array(
                    'class'=>'input-medium',
                    'data-bvalidator'=>'required'),                                
                ))
            ->add('fechainicionoticia','date',array(
                'label' => 'Inicio',
                'widget' => 'single_text', 
                'format'=>'dd-MM-yyyy',
                'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true),
                ))
            ->add('fechafinnoticia','date',array(
                'label' => 'Fin',
                'widget' => 'single_text', 
                'format'=>'dd-MM-yyyy',
                'attr' => array('class' => 'date input-small', 'data-bvalidator'=>'required', 'readonly'=>true),
                ))
            ->add('contenidonoticia','textarea',array(
                'label'=>'Contenido',
                'attr'=>array(
                    'class'=>'form-control',
                    'rows'=>3,
                    'data-bvalidator'=>'required'),
                ))
            ->add('idcentro',null,array(
                'label'=>'A quién publicar',
                'empty_value' => 'Seleccione una opción',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\AdminBundle\Entity\Noticia'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_adminbundle_noticiatype';
    }
}
