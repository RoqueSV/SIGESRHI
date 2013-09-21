<?php


//src/SIGESRHI/AdminBundle/Admin/TituloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class TituloAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombretitulo', null, array('label' => 'Titulo'))
            ->add('niveltitulo', 'choice', array('choices'   
                                           => array('Educación Media' => 'Educación Media', 
                                                    'Educación Superior' => 'Educación Superior',
                                                    'Postgrado'=>'Postgrado'),
                                           'required'  => true, 'label'=>'Sexo'))
            ->setHelps(array('nombretitulo'=>'Ingrese el titulo requerido'))
           
             ;
    }
    
        //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
          ->add('nombretitulo', null, array('label' => 'Titulo'))
          ->add('niveltitulo', null, array('label' => 'Nivel Titulo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombretitulo', null,array('label' => 'Titulo'))
            ->add('niveltitulo', null, array('label' => 'Nivel Titulo'))
                   
        ;
    }
    
}
