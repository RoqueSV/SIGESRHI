<?php


//src/SIGESRHI/AdminBundle/Admin/ModuloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ModuloAdmin extends Admin
{
    protected $baseRoutePattern = 'modulo';
    
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombremodulo', 'text', array('label' => 'Modulo','required'=>'required'))
            ->add('descripcion','textarea', array('required'=>'required'))
            ->setHelps(array('nombremodulo'=>'Ingrese un módulo', 'descripcion'=>'Ingrese una descripción para el módulo'))
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombremodulo',null, array('label' => 'Módulo'))
            ->add('descripcion', null, array('label' => 'Descripción'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
         $listMapper
            ->addIdentifier('nombremodulo', null,array('label' => 'Módulo'))
            ->add('descripcion', null,array('label' => 'Descripción'))
              
        ;
    }
}
