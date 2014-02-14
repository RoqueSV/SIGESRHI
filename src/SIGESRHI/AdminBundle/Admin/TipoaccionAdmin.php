<?php


//src/SIGESRHI/AdminBundle/Admin/TipoaccionAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TipoaccionAdmin extends Admin
{
    public $baseRoutePattern = '/tipoaccion';
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombretipoaccion', 'text', array('label' => 'Nombre acción'))
            ->add('descripciontipoaccion', 'textarea', array('label' => 'Descripción'))
            ->add('tipoaccion', 'choice', array(
                  'label' => 'Tipo acción',
                  'choices' => array(
                  '1' => 'Genera acuerdo', '2' => 'No genera acuerdo'),
                  'required'=> true, 'empty_value' => 'Seleccione una opción'))
            ->setHelps(array('nombretipoaccion'=>'Ingrese un nombre para la acción de personal',
                             'tipoaccion'=>'Seleccione la categoría de la accion personal' ))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombretipoaccion', null, array('label' => 'Nombre acción'))
            ->add('tipoaccion', null, array(
                  'label' => 'Tipo',
                  ))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombretipoaccion',null,array('label' => 'Nombre acción','route' => array('name' => 'show')))
            ->add('tipoaccion', 'string', array(
                  'label' => 'Tipo',
                  'template' => 'AdminBundle:CRUD:tiposaccion.html.twig'
                  ))
                     
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombretipoaccion', 'text', array('label' => 'Nombre acción'))
            ->add('descripciontipoaccion', 'textarea', array('label' => 'Descripción'))
            ->add('tipoaccion', 'string', array(
                  'label' => 'Tipo',
                  'template' => 'AdminBundle:CRUD:tiposaccionshow.html.twig'
                  ))
        ;
     }
    
}