<?php


//src/SIGESRHI/AdminBundle/Admin/ManejoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ManejoAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombremanejo', 'textarea', array('label' => 'Descripción manejo de equipo'))
            ->setHelps(array('nombremanejo'=>'Ingrese la descripción de manejos de equipo requeridos'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombremanejo', null, array('label' => 'Descripción manejo de equipo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombremanejo', null,array('label' => 'Descripción manejo de equipo'))
                   
        ;
    }
    
}
