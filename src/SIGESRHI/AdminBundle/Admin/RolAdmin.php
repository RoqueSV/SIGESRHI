<?php


//src/SIGESRHI/AdminBundle/Admin/RolAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class RolAdmin extends Admin
{
   
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrerol', 'text', array('label' => 'Rol'))
            ->add('idacceso',null,array('multiple'=>true,'expanded'=>true, 'label'=>'Opciones'))
            ->setHelps(array('nombrerol'=>'Ingresa un rol'))
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombrerol',null, array('label' => 'Rol'))
            ->add('idacceso')
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrerol', null,array('label' => 'Rol')) 
            ->add('idacceso')
        ;
    }
}