<?php


//src/SIGESRHI/AdminBundle/Admin/CentroAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CentroAdmin extends Admin
{
    protected $baseRoutePattern = 'centro';
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrecentro', null, array('label' => 'Centro de Atención'))
            ->add('especialidad','textarea')
            ->add('direccioncentro','textarea', array('label' => 'Dirección'))
            ->add('emailcentro',null, array('label' => 'Email'))
            ->add('faxcentro',null, array('label' => 'Fax', 'max_length'=>'8'))
            ->add('pbxcentro',null, array('label' => 'PBX', 'max_length'=>'8'))
            ->add('idtelefono','sonata_type_model',array('required'=>true,'multiple'=>true,'expanded'=>true ,'label'=>'Teléfono'))
            ->setHelps(array('nombrecentro'=>'Ingrese el nombre de un centro de atención o unidad',
                             'especialidad'=>'Defina la especialidad para centro de atención o unidad',
                             'direccioncentro'=>'Ingrese la dirección del centro',
                             'faxcentro'=>'Ingrese un número de fax sin guiones',
                             'pbxcentro'=>'Ingrese un número pbx',
                             'emailcentro'=>'Ingrese el correo eléctronico del centro'))
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombrecentro', null, array('label' => 'Centro de Atención'))
            ->add('especialidad')
          /* ->add('direccioncentro',null, array('label' => 'Dirección'))  */
          /*  ->add('telefonocentro',null, array('label' => 'Teléfono'))   */
          /*  ->add('extensioncentro',null, array('label' => 'Extensión')) */
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrecentro', null,array('label' => 'Centro de atención', 'route' => array('name' => 'show')))
            ->add('especialidad')
            ->add('direccioncentro',null, array('label' => 'Dirección'))
            ->add('emailcentro',null, array('label' => 'Email'))
                      
        ;
    }

        protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombrecentro', null, array('label' => 'Centro de Atención'))
            ->add('especialidad')
            ->add('direccioncentro',null, array('label' => 'Dirección'))
            ->add('emailcentro',null, array('label' => 'Email'))
            ->add('faxcentro',null, array('label' => 'Fax'))
            ->add('pbxcentro',null, array('label' => 'PBX'))
            ->add('idtelefono','sonata_type_model',array('label'=>'Teléfono'))
        ;
     }
}