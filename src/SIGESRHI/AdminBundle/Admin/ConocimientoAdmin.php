<?php


//src/SIGESRHI/AdminBundle/Admin/ConocimientoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ConocimientoAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombreconocimiento', 'textarea', array('label' => 'Descripción conocimiento'))
            ->setHelps(array('nombreconocimiento'=>'Ingresa la descripción de conocimientos requeridos'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombreconocimiento', null, array('label' => 'Descripción conocimiento'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreconocimiento', null,array('label' => 'Descripción conocimiento'))
                   
        ;
    }
    
}