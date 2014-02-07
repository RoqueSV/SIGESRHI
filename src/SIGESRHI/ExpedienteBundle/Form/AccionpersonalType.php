<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class AccionpersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecharegistroaccion', null, array('label'=>'Fecha de Registro: ','widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'input-medium date', 'readonly'=>true)))
            ->add('motivoaccion', 'textarea', array('label'=>'Descripción del acuerdo: ', 'attr' => array('class' => 'input-xmlarge', 'rows'=> 4)))
            ->add('numacuerdo', null, array('label'=>'Numero de Acuerdo: ', 'attr' => array('class' => 'input-medium')))
            ->add('idtipoaccion', 'entity', array('label'=>'Tipo de Acuerdo: ', 'empty_value' => 'Seleccione', 'required' => true, 'attr' => array('class' => 'input-xlarge'), 
                'class' => 'ExpedienteBundle:Tipoaccion', 
                        'query_builder' => function(EntityRepository $er) {
                                           return $er->createQueryBuilder('u')->AndWhere('u.tipoaccion = :var and u.id not in (4,6,7)')->setParameter('var','1');
                                           },
                                    ))//fin add

            //->add('idexpediente')
        ;
    } 

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Accionpersonal'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_accionpersonaltype';
    }
}
