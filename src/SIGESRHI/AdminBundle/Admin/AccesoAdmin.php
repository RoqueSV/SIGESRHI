<?php


//src/SIGESRHI/AdminBundle/Admin/AccesoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AccesoAdmin extends Admin
{
   // public $supportsPreviewMode = true;
   protected $baseRoutePattern = 'acceso';
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrepagina', null, array('label' => 'Opción'))
            ->add('idmodulo','sonata_type_model',array('required'=>'required', 'label'=>'Modulo'))
            ->add('ruta')
            ->add('idaccesosup', null , array('label'=>'Acceso superior'))
            ->setHelps(array('nombrepagina'=>'Ingrese una opción de acceso',
                             'ruta'=>'Identificador de la ruta, p.ej. hello_page'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombrepagina',null, array('label' => 'Opción'))
            ->add('idmodulo',null,array('label'=>'Modulo'))
            ->add('ruta')
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrepagina', null,array('label' => 'Opción','route' => array('name' => 'show')))
            ->add('idmodulo',null,array('label'=>'Modulo'))
            ->add('ruta')
            ->add('idaccesosup',null, array('label'=>'Acceso superior'))
            ->add('idrol',null,array('label'=>'Roles'))    
        ;
    }

     protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
         ->add('nombrepagina',null, array('label' => 'Opción'))
         ->add('idmodulo',null,array('label'=>'Modulo'))
         ->add('ruta')  
         ->add('idaccesosup',null, array('label'=>'Acceso superior'))
        ;
     }
     


}