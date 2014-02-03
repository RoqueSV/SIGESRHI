<?php


//src/SIGESRHI/AdminBundle/Admin/TituloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ConocimientoplazaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('idconocimiento','sonata_type_model', array('label' => 'Conocimiento'))
            //->add('idplaza', null, array('label' => 'Plaza'))
            ->add('tipoconocimiento', 'choice', array(
                  'choices'=> array('I' => 'Indispensable', 
                                    'D' => 'Deseable'),
                  'empty_value'=>'Seleccione',
                  'required'  => true, 'label'=>'Tipo'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('idconocimiento',null, array('label' => 'Conocimiento'))   
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
          ->add('idconocimiento',null, array('label' => 'Conocimiento'))      
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show'));
    }
    
}
