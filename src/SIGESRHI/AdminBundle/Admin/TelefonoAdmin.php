<?php


//src/SIGESRHI/AdminBundle/Admin/TelefonoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class TelefonoAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('numtelefono', null, array('label'=>'Teléfono','attr'=>array('data-bvalidator'=>'phone',)))
            ->setHelps(array('numtelefono'=>'Ingrese un numero teléfonico sin guiones'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('numtelefono', null, array('label' => 'Teléfono'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numtelefono', null,array('label' => 'Teléfono'))
                   
        ;
    }
    
}