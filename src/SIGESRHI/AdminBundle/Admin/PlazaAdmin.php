<?php


//src/SIGESRHI/AdminBundle/Admin/PlazaAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PlazaAdmin extends Admin
{
    public $baseRouteName = 'plaza';
    public $baseRoutePattern = '/plaza';
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {    
       $formMapper
           ->with('General')    
            ->add('nombreplaza', null, array('label' => 'Plaza','help'=>'Digite el nombre de la plaza'))
            ->add('descripcionplaza', 'textarea', array('label' => 'Descripción','help'=>'Ingrese una descripción para la plaza'))
            ->add('edad', 'integer', array('max_length'=>'2','label' => 'Edad requerida', 'help'=>'Ingrese la edad requerida'))
            ->add('estadoplaza', 'choice', array('choices'   => array('A' => 'Activa', 'I' => 'Inactiva'),'required'  => true, 'label'=>'Estado'))
            ->add('idarea','sonata_type_model',array('required'=>'required', 'label'=>'Area'))
           ->end()
           ->with('Funciones')
             ->add('idfuncion','sonata_type_model',array('required'=>true,'multiple'=>true,'expanded'=>true ,'label'=>'Funciones'))
           ->end()
           ->with('Conocimientos')
             ->add('idconocimiento','sonata_type_model',array('required'=>true,'multiple'=>true,'expanded'=>true ,'label'=>'Conocimientos'))
           ->end()
           ->with('Habilidades')
             ->add('idhabilidad','sonata_type_model',array('required'=>true,'multiple'=>true,'expanded'=>true ,'label'=>'Habilidades')) 
           ->end()
           ->with('Manejo de Equipo')
             ->add('idmanejoequipo','sonata_type_model',array('required'=>false,'multiple'=>true,'expanded'=>true ,'label'=>'Manejo de Equipo'))
           ->end()
           ->with('Documentación', array('description' => 'En esta sección tiene la posibilidad de adjuntar el documento necesario que respalde la acción realizada sobre la plaza.'))
            ->add('name',null,array('label'=>'Documento', 'help'=>'Digite un nombre para el documento'))
            ->add('file', 'file', array('required' => false,'label'=>'Archivo'))
            ->add('observaciones',null, array('help'=>'Ingrese las observaciones que considere necesarias'))   
           ->end()
            
            ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombreplaza', null, array('label' => 'Plaza'))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea', null, array('label' => 'Area'))
           // ->add('idconocimiento', null, array('label' => 'Conocimientos'))
           // ->add('idfuncion', null, array('label' => 'Funciones'))
           // ->add('idhabilidad', null, array('label' => 'Habilidades')) 
           // ->add('idmanejoequipo', null, array('label' => 'Manejo equipo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreplaza',null,array('label'=>'Plaza'))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('edad', 'integer', array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea', 'textarea', array('label' => 'Area',))
           // ->add('idconocimiento', null, array('label' => 'Conocimientos'))
           // ->add('idfuncion', null, array('label' => 'Funciones'))
           // ->add('idhabilidad', null, array('label' => 'Habilidades')) 
           // ->add('idmanejoequipo', null, array('label' => 'Manejo equipo'))
        ;
    }
    
   protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Generales')     
            ->add('nombreplaza', null, array('label' => 'Plaza'))
            ->add('descripcionplaza', 'textarea', array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea',null,array('label'=>'Area'))
            ->add('observaciones')
           ->end()
           ->with('Funciones')
             ->add('idfuncion',null,array('label'=>'Funciones'))
           ->end()
           ->with('Conocimientos')
             ->add('idconocimiento',null,array('label'=>'Conocimientos'))
           ->end()
           ->with('Habilidades')
             ->add('idhabilidad',null,array('label'=>'Habilidades')) 
           ->end()
           ->with('Manejo de Equipo')
             ->add('idmanejoequipo',null,array('label'=>'Manejo de Equipo'))
           ->end()
        ;
    }
    
    public function prePersist($plaza) {
       $this->saveFile($plaza);
    }

    public function preUpdate($plaza) {
       $this->saveFile($plaza);
    }

    public function saveFile($plaza) {
        $basepath=$this->getRequest()->getBasePath();
        $plaza->upload($basepath);    
        $plaza->refreshUpdated();
        }
}