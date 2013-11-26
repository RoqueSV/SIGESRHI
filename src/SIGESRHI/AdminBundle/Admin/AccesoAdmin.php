<?php


//src/SIGESRHI/AdminBundle/Admin/AccesoAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;

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
            ->add('idaccesosup', 'entity' , array('required' => false,
                                                  'label'=>'Acceso superior',
                                                  'class' => 'AdminBundle:Acceso',
                                                  'query_builder' => function(EntityRepository $er) {
                                                                 return $er->createQueryBuilder('a')
                                                                           //->where('a.idaccesosup is null')
                                                                           ->orderBy('a.nombrepagina', 'ASC');
                                                                            },                
                                                                           ))
            
            ->setHelps(array('nombrepagina'=>'Ingrese una opción de acceso',
                             'ruta'=>'Identificador de la ruta, p.ej. hello_page',
                             'idaccesosup'=>'Elija solo si la opción registrada es dependiente de otra'))
           
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