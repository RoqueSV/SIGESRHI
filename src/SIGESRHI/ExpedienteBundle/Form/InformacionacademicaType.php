<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InformacionacademicaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('centroestudio','genemu_jqueryautocomplete_entity', array('class' => 'ExpedienteBundle:Informacionacademica','label'=> 'Centro de Estudios','attr' =>array('class'=> 'input-xlarge')))
           ->add('idtitulo', 'genemu_jqueryselect2_entity', array(
            'class' => 'ExpedienteBundle:Titulo', 'label'=> 'Titulo Obtenido',
            'empty_value' => 'Seleccione una opción',
            'required'=> true,
            'attr' =>array('class'=> 'input-xmlarge')
            ))
   ; 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Informacionacademica'
        ));
    }

    public function getName()
    {
        return 'informacionacademica';
    }
}
