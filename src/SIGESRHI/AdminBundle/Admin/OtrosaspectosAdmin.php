<?php


//src/SIGESRHI/AdminBundle/Admin/TituloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OtrosaspectosAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombreotrosaspectos',null, array('label' => 'Otros aspectos'))
            //->add('idplaza', null, array('label' => 'Plaza'))           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
         // ->add('idtitulo', null, array('label' => 'Titulo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
          //->addIdentifier('idtitulo', null,array('label' => 'Titulo'))                   
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show'));
    }
    
}
