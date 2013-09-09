<?php


//src/SIGESRHI/AdminBundle/Admin/ModuloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ModuloAdmin extends Admin
{
   
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombremodulo', 'text', array('label' => 'Modulo'))
            ->add('descripcion',null, array('required'=>'required'))
            ->setHelps(array('nombremodulo'=>'Ingresa un módulo', 'descripcion'=>'Ingresa una descripción'))
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombremodulo',null, array('label' => 'Módulo'))
            ->add('descripcion')
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombremodulo', null,array('label' => 'Módulo'))
            ->add('descripcion')
                
        ;
    }
}
