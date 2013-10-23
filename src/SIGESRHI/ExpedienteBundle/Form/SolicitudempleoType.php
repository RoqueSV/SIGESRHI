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
            //->add('numsolicitud')
            ->add('apellidocasada', null, array('label'=>'Apellido de Casada: ', 'attr'=>array('class'=>'input-medium')))
            ->add('primerapellido', null, array('label'=>'Primer Apellido: ', 'attr'=>array('class'=>'input-medium')))
            ->add('segundoapellido', null, array('label'=>'Segundo Apellido: ', 'attr'=>array('class'=>'input-medium')))
            ->add('nombres', null, array('label'=>'Nombres: ','attr'=>array('class'=>'input-medium')))
            ->add('colonia', null, array('label'=>'Colonia: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('calle', null, array('label'=>'Numero/Calle/Avenida: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('estadocivil', 'choice', array('label'=>'Estado Civil: ',
                'choices' => array('S' => 'Soltero', 'A' => 'Acompañado', 'C' => 'Casado', 'D' => 'Divorciado', 'V' => 'Viudo'),'required'  => true, 'empty_value' => 'Seleccione una opción'))
            ->add('telefonofijo', null, array('label'=>'Teléfono Fijo: ', 'max_length'=>'8', 'attr'=>array('class'=>'input-small telefono', 'data-bvalidator'=>'phone,required')))
            ->add('telefonomovil', null, array('label'=>'Teléfono Móvil: ', 'max_length'=>'8', 'attr'=>array('class'=>'input-small telefono', 'data-bvalidator'=>'phone,required')))
            ->add('email', null, array('label'=>'Correo Electrónico: ', 'attr'=>array('class'=>'input-xlarge', 'data-bvalidator'=>'email,required')))
            ->add('lugarnac', null, array('label'=>'Lugar de Nac.: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('fechanac', null, array('label'=>'Fecha de Nac.: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'readonly'=>true),) ) 
            ->add('dui', null, array('label'=>'DUI:', 'max_length'=>'9', 'attr' =>array('placeholder'=>'Sin guiones', 'class'=> 'input-small dui', 'data-bvalidator'=>'number,required')))
            ->add('lugardui', null, array('label'=>'Lugar donde se extendió el DUI: '))
            ->add('fechadui', null, array('label'=>'Fecha se extendió el DUI: ', 'widget' => 'single_text', 'format'=>'dd-MM-yyyy','attr' => array('class' => 'date input-small', 'readonly'=>true),))
            ->add('nit', null, array('label'=>'No NIT: ', 'max_length'=>'14','attr' =>array('placeholder'=>'Digite NIT sin guiones', 'data-bvalidator'=>'number,required', 'class'=>'nit input-medium')))
            ->add('isss', null, array('label'=>'No ISSS: ', 'max_length'=>'9', 'attr' =>array('class'=> 'input-small isss', 'data-bvalidator'=>'number')))
            ->add('nup', null, array('label'=>'No NUP: ', 'max_length'=>'12', 'attr'=>array('class'=>'nup input-medium', 'data-bvalidator'=>'number')))
            ->add('nip', null, array('label'=>'No NIP: ', 'max_length'=>'7', 'attr' =>array('class'=> 'input-small nip', 'data-bvalidator'=>'number')))
            ->add('sexo', 'choice', array('label'=>'Sexo: ',
                'choices' => array('M' => 'Masculino', 'F' => 'Femenino'),'required'  => true, 'empty_value' => 'Seleccione una opción'))
            //->add('fotografia', null, array('label'=>' Subir Fotografía: ', 'required'=>true))
            ->add('file', 'file', array('label'=>' Subir Fotografía: ', 'required'=>true))
           // ->add('fecharegistro',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'readonly'=>true) ))
            //->add('fechamodificacion',null, array('widget' => 'single_text', 'format'=>'dd-MM-yyyy', 'attr' => array('class' => 'date input-small', 'readonly'=>true)))
            ->add('idmunicipio', null,array('required' => true,'label'=>'Municipio: ', 'empty_value' => 'Seleccione una opción' ))
            ->add('departamentos', 'entity', array( 'label'=>'Departamento: ', 'class' => 'ExpedienteBundle:Departamento', 'empty_value' => 'Seleccione una opción', 'mapped'=>false, ))
            ->add('idplaza', null, array('required'=> true, 'label'=>'Plaza Solicitada: ', 'empty_value'=>'Seleccione una Opción', 'attr'=>array('class'=>'input-xxlarge')))
            //->add('idexpediente')
            ->add('nombreparinst', null, array('label'=>'Nombre del Pariente: ', 'attr'=>array('class'=>'input-xlarge')))
            ->add('parentescoparinst',null, array('label'=>'Parentesco: ', 'required'=>false , 'attr'=>array('class'=>'input-medium')))
            ->add('dependenciaparinst', 'entity', array( 'label'=>'Dependencia donde labora: ','class'=>'AdminBundle:Unidadorganizativa', 'empty_value'=>'Seleccione una opción', 'mapped'=>false, 'required'=>false, 'attr' =>array('class'=> 'input-xxlarge')))
            ->add('aceptar', 'checkbox', array ('label' => 'Declaro bajo juramento que los datos registrados en la solicitud son verdaderos y autorizo al Instituto Salvadoreño de Rehabilitacion Integral para su respectiva verificación.'
                ,'required' => true, 'attr'=>array('class'=>'checkbox')))
            ;

            //agregamos un formulario de otra entidad (datos empleo)
            $builder->add('Dempleos', 'collection', array('label'=>' ', 'type' => new DatosempleoType(), 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false, 'options'=>array('cascade_validation' => true))); //'options'=>array('cascade_validation' => true)
            $builder->add('Dfamiliares', 'collection', array('label'=>' ', 'type' => new DatosfamiliaresType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false, 'required'=>true));
            $builder->add('Destudios', 'collection', array('type' => new InformacionacademicaType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,));
            $builder->add('Idiomas', 'collection', array('label'=>' ', 'type' => new IdiomaType(), 'allow_add' => true, 'allow_delete' => true,'by_reference' => false,));
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
