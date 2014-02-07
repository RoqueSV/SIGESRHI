<?php


//src/SIGESRHI/AdminBundle/Admin/TituloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class IdiomasplazaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('idotrosidiomas','sonata_type_model', array('label' => 'Idioma'))
            //->add('idplaza', null, array('label' => 'Plaza'))
            ->add('tipoidioma', 'choice', array(
                  'choices'=> array('I' => 'Indispensable', 
                                    'D' => 'Deseable'),
                  'empty_value'=>'Seleccione',
                  'required'  => true, 'label'=>'Tipo'))
            ->add('nivelidioma', 'choice', array(
                  'choices'=> array('B' => 'Básico', 
                                    'I' => 'Intermedio',
                                    'A' => 'Avanzado'),
                  'empty_value'=>'Seleccione',
                  'required'  => true, 'label'=>'Nivel'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
         ->add('idotrosidiomas',null, array('label' => 'Idioma'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
          ->add('idotrosidiomas',null, array('label' => 'Idioma'))                  
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show','create'));
    }
    
}
