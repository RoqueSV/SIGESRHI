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
            ->add('centroestudio',null, array('label'=> 'Centro de Estudios '))
           // ->add('idsolicitudempleo')
           // ->add('idtitulo', null,array('required' => true,'label'=>'Titulo Obtenido' ))
           // ->add('Idtitulo', 'collection', array('type' => new TituloType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,))
            ->add('idtitulo',null, array('required'=> true, 'label'=>'Título Obtenido: ', 'multiple'=>false))
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
        return 'sigesrhi_expedientebundle_informacionacademicatype';
    }
}
