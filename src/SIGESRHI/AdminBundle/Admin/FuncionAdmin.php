<?php


//src/SIGESRHI/AdminBundle/Admin/FuncionAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class FuncionAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrefuncion', 'textarea', array('label' => 'Descripción funcion'))
            ->setHelps(array('nombrehabilidad'=>'Ingrese la descripción de funciones requeridas'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombrefuncion', null, array('label' => 'Descripción funcion'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrefuncion', null,array('label' => 'Descripción funcion'))
                   
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show'));
    }
    
}
