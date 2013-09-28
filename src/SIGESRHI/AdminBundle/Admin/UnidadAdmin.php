<?php


//src/SIGESRHI/AdminBundle/Admin/UnidadAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UnidadAdmin extends Admin
{
   
    protected $baseRoutePattern = 'unidad';
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombreunidad', null, array('label' => 'Unidad Organizativa'))
            ->add('descripcionunidad', null, array('label' => 'Descripción'))
            ->add('idcentro',null,array('required'=>'required', 'label'=>'Centro Atención'))
            ->setHelps(array('nombreunidad'=>'Ingrese una unidad organizativa',
                             'descripcionunidad'=>'Ingrese una descripción'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombreunidad', null, array('label' => 'Unidad Organizativa'))
          //->add('descripcionunidad', null, array('label' => 'Descripción'))
            ->add('idcentro',null,array('label'=>'Centro Atención'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreunidad', null,array('label' => 'Unidad Organizativa', 'route' => array('name' => 'show')))
            ->add('descripcionunidad', null, array('label' => 'Descripción'))
            ->add('idcentro',null,array('label'=>'Centro Atención'))
       
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombreunidad', null, array('label' => 'Unidad Organizativa'))
            ->add('descripcionunidad', null, array('label' => 'Descripción'))
            ->add('idcentro',null,array('label'=>'Centro de Atención'))
        ;
     }
    
}
