<?php


//src/SIGESRHI/AdminBundle/Admin/HabilidadAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class HabilidadAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrehabilidad', 'textarea', array('label' => 'Descripción habilidad'))
            ->setHelps(array('nombrehabilidad'=>'Ingrese la descripción de habilidades requeridas'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombrehabilidad', null, array('label' => 'Descripción habilidad'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrehabilidad', null,array('label' => 'Descripción habilidad'))
                   
        ;
    }
    
}