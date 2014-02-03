<?php


//src/SIGESRHI/AdminBundle/Admin/HabilidadAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CompetenciaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombrecompetencia', 'textarea', array('label' => 'Descripción competencia'))
            ->setHelps(array('nombrecompetencia'=>'Ingrese la descripción de competencias conductuales'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombrecompetencia', null, array('label' => 'Descripción competencia'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombrecompetencia', null,array('label' => 'Descripción competencia'))
                   
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show'));
    }
    
}