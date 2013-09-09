<?php


//src/SIGESRHI/AdminBundle/Admin/AreaAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class AreaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrearea', null, array('label' => 'Area'))
            ->add('descripcionarea', null, array('label' => 'Descripción'))
            ->setHelps(array('nombrearea'=>'Ingresa una area'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombrearea', null, array('label' => 'Area'))
            ->add('descripcionarea', null, array('label' => 'Descripción'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrearea', null,array('label' => 'Descripción'))
            ->add('descripcionarea', null, array('label' => 'Descripción'))
                     
        ;
    }
    
}