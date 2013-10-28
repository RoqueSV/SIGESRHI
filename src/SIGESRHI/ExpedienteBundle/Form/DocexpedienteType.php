<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocexpedienteType extends AbstractType
{
    protected $idexpediente;

        public function __construct($idexpediente){
            $this->idexpediente=$idexpediente;
        }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('nombredocexp', null, array('label'=>'Nombre del documento/archivo: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('file', null, array('label'=>'Subir documento/archivo: '))
            ->add('fechadocexp',null, array('label'=>'Fecha Creación', 'widget'=>'single_text', 'format'=>'dd-MM-yyyy', 'attr'=>array('class'=>'date input-small', 'readonly'=>true)))
            ->add('idexpediente', 'hidden', array('data'=>$this->idexpediente,))
        ;
       //$builder->add('Docexpediente', 'collection', array('label'=>' ', 'type' => new DocexpedienteType(), 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false, ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Docexpediente'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_docexpedientetype';
    }
}
