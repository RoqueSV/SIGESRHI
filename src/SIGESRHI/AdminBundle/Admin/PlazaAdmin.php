<?php


//src/SIGESRHI/AdminBundle/Admin/PlazaAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PlazaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombreplaza', null, array('label' => 'Plaza'))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label' => 'Estado'))
            ->add('idarea','sonata_type_model',array('required'=>false,'label' => 'Area', 'multiple' => true, 'expanded'=>true))
            ->add('idconocimiento', 'sonata_type_model', array('required'=>false,'label' => 'Conocimientos', 'multiple' => true))
            ->add('idfuncion', 'sonata_type_model', array('required'=>false, 'multiple' => true, 'label' => 'Funciones')) 
            ->add('idhabilidad', 'sonata_type_model', array('required'=>false, 'multiple' => true, 'label' => 'Habilidades')) 
            ->add('idmanejoequipo', 'sonata_type_model', array('required'=>false, 'multiple' => true, 'label' => 'Manejo equipo'))
            ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombreplaza', null, array('label' => 'Plaza'))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label' => 'Estado'))
            ->add('idarea', null, array('label' => 'Area'))
            ->add('idconocimiento', null, array('label' => 'Conocimientos'))
            ->add('idfuncion', null, array('label' => 'Funciones'))
            ->add('idhabilidad', null, array('label' => 'Habilidades')) 
            ->add('idmanejoequipo', null, array('label' => 'Manejo equipo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreplaza', null,array('label' => 'Plaza'))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('estadoplaza', null, array('label' => 'Estado'))
            ->add('idarea', null, array('label' => 'Area'))
            ->add('idconocimiento', null, array('label' => 'Conocimientos'))
            ->add('idfuncion', null, array('label' => 'Funciones'))
            ->add('idhabilidad', null, array('label' => 'Habilidades')) 
            ->add('idmanejoequipo', null, array('label' => 'Manejo equipo'))
        ;
    }
    
}