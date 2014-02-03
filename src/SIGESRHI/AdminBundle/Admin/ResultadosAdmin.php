<?php


//src/SIGESRHI/AdminBundle/Admin/AreaAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ResultadosAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombreresultado', 'textarea', array('label' => 'Resultado'))
            ->setHelps(array('nombrearea'=>'Ingrese la descripción del resultado esperado'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombreresultado', null, array('label' => 'Resultado'))
           // ->add('descripcionarea', null, array('label' => 'Descripción'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreresultado', null,array('label' => 'Descripción'))
          //  ->add('descripcionarea', null, array('label' => 'Descripción'))
                     
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show'));
    }
    
}