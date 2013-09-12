<?php


//src/SIGESRHI/AdminBundle/Admin/CentroAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CentroAdmin extends Admin
{
    protected $baseRoutePattern = 'centro';
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrecentro', null, array('label' => 'Centro de Atención'))
            ->add('especialidad')
            ->add('direccioncentro','textarea', array('label' => 'Dirección'))
            ->add('telefonocentro',null, array('label' => 'Teléfono', 'max_length'=>'8','attr' => array('class' => ':phone :only_on_blur')))
            ->add('extensioncentro','integer', array('label' => 'Extensión'))
            ->setHelps(array('nombrecentro'=>'Ingrese el nombre de un centro de atención o unidad',
                             'especialidad'=>'Defina la especialidad para centro de atención o unidad',
                             'direccioncentro'=>'Ingrese la dirección del centro',
                             'telefonocentro'=>'Ingrese un número teléfonico sin guiones',
                             'extensioncentro'=>'Ingrese la extensión'))
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
            ->addIdentifier('nombrecentro', null,array('label' => 'Centro de atención'))
            ->add('especialidad')
            ->add('direccioncentro',null, array('label' => 'Dirección'))
            ->add('telefonocentro',null, array('label' => 'Teléfono'))
            ->add('extensioncentro',null, array('label' => 'Extensión'))                
        ;
    }
}