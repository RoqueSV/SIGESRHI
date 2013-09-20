<?php


//src/SIGESRHI/AdminBundle/Admin/AuditoriaAdmin.php

namespace SIGESRHI\AdminBundle\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;
//use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class AuditoriaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
   protected $baseRoutePattern = 'auditoria';
    
    //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('accionrealizada',null, array('label' => 'Operación'))
            ->add('tablaafectada',null,array('label'=>'Tabla afectada'))
          //  ->add('valorold',null,array('label'=>'Valor anterior'))
          //  ->add('valornew',null,array('label'=>'Valor nuevo'))
            ->add('fechaaccion',null,array('label'=>'Fecha'))
          //  ->add('usuarioaccion',null,array('label'=>'Usuario'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('accionrealizada',null, array('label' => 'Operación'))
            ->add('tablaafectada',null,array('label'=>'Tabla afectada'))
           // ->add('valorold',null,array('label'=>'Valor anterior'))
           // ->add('valornew',null,array('label'=>'Valor nuevo'))
            ->add('fechaaccion',null,array('label'=>'Fecha'))
            ->add('usuarioaccion',null,array('label'=>'Usuario'))   
        ;
    }
    
    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('list'));
}
    
}