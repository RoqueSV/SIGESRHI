<?php

namespace SIGESRHI\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudempleoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numsolicitud')
            ->add('apellidocasada', null, array('label'=>'Apellido de Casada: '))
            ->add('primerapellido', null, array('label'=>'Primer Apellido: '))
            ->add('segundoapellido', null, array('label'=>'Segundo Apellido: '))
            ->add('nombres', null, array('label'=>'Nombres: '))
            ->add('colonia', null, array('label'=>'Colonia: '))
            ->add('calle', null, array('label'=>'Numero/Calle/Avenida: '))
            ->add('estadocivil', 'choice', array('label'=>'Estado Civil: ',
                'choices' => array('S' => 'Soltero', 'A' => 'Acompañado', 'C' => 'Casado', 'D' => 'Divorciado', 'V' => 'Viudo'),'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('telefonofijo', null, array('label'=>'Teléfono Fijo: ', 'max_length'=>'8', 'attr'=>array('class'=>'input-small')))
            ->add('telefonomovil', null, array('label'=>'Teléfono Móvil: ', 'max_length'=>'8', 'attr'=>array('class'=>'input-small')))
            ->add('email', null, array('label'=>'Correo Electrónico: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('lugarnac', null, array('label'=>'Lugar de Nac.: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('fechanac', 'date', array('label'=>'Fecha de Nac.: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'readonly'=>true),) ) 
            ->add('dui', null, array('label'=>'DUI', 'max_length'=>'9', 'attr' =>array('placeholder'=>'Sin guiones', 'class'=> 'input-small')))
            ->add('lugardui', null, array('label'=>'Lugar donde se extendió el DUI: '))
            ->add('fechadui', null, array('label'=>'Fecha se extendió el DUI: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy','attr' => array('class' => 'date input-small', 'readonly'=>true),))
            ->add('nit', null, array('label'=>'No NIT: ', 'max_length'=>'14','attr' =>array('placeholder'=>'Digite NIT sin guiones')))
            ->add('isss', null, array('label'=>'No ISSS: ', 'max_length'=>'9', 'attr' =>array('class'=> 'input-small')))
            ->add('nup', null, array('label'=>'No NUP: ', 'max_length'=>'12'))
            ->add('nip', null, array('label'=>'No NIP: ', 'max_length'=>'7', 'attr' =>array('class'=> 'input-small')))
            ->add('sexo', 'choice', array('label'=>'Sexo: ',
                'choices' => array('M' => 'Masculino', 'F' => 'Femenino'),'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('fotografia', 'file', array('label'=>' Subir Fotografía: ', 'required'=>false))
            ->add('fecharegistro',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('fechamodificacion',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy'))
            ->add('idmunicipio',null,array('required' => true,'label'=>'Municipio', 'empty_value' => 'Seleccione una opción' ))
            ->add('departamentos', 'entity', array('class' => 'ExpedienteBundle:Departamento', 'empty_value' => 'Seleccione una opción', 'mapped'=>false))
            ->add('idplaza',null, array('required'=> true, 'label'=>'Plaza Solicitada: ', 'empty_value' => 'Seleccione una opción', 'attr'=>array('class'=>'input-xlarge')))
            ->add('idexpediente')
            ->add('nombreparinst', null, array('label'=>'Nombre del Pariente: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('parentescoparinst',null, array('label'=>'Parentesco: '))
            ->add('dependenciaparinst', 'entity', array( 'label'=>'Dependencia donde labora: ','class'=>'AdminBundle:Unidadorganizativa', 'empty_value'=>'Seleccione una opción', 'mapped'=>false))
            ;

            //agregamos un formulario de otra entidad (datos empleo)
            $builder->add('Dempleos', 'collection', array('type' => new DatosempleoType(),));
            $builder->add('Dfamiliares', 'collection', array('type' => new DatosfamiliaresType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,));
            $builder->add('Destudios', 'collection', array('type' => new InformacionacademicaType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,));
            $builder->add('Idiomas', 'collection', array('type' => new IdiomaType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,));
        ;   
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SIGESRHI\ExpedienteBundle\Entity\Solicitudempleo'
        ));
    }

    public function getName()
    {
        return 'sigesrhi_expedientebundle_solicitudempleotype';
    }
}
