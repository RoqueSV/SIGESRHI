<?php


//src/SIGESRHI/AdminBundle/Admin/ManejoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class MarcoreferenciaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombremarcoref', 'text', array('label' => 'Descripción de marco de referencia'))
            ->setHelps(array('nombremarcoref'=>'Ingrese la descripción del marco de referencia'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombremarcoref', null, array('label' => 'Descripción marcos de referencia'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombremarcoref', null,array('label' => 'Descripción marcos de referencia'))
                   
        ;
    }
    
}
