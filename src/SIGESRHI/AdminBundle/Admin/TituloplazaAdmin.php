<?php


//src/SIGESRHI/AdminBundle/Admin/TituloAdmin.php

namespace SIGESRHI\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class TituloplazaAdmin extends Admin
{
   // public $supportsPreviewMode = true;
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $em = $this->modelManager->getEntityManager('ExpedienteBundle:Titulo');

        $queryt = $em->createQueryBuilder('t')
                     ->select('t')
                     ->from('ExpedienteBundle:Titulo', 't')
                     ->orderBy('t.nombretitulo', 'ASC');


        $formMapper
            ->add('idtitulo','sonata_type_model', 
                   array(
                  'label' => 'Titulo',
                  'query' => $queryt))
            //->add('idplaza', null, array('label' => 'Plaza'))
            ->add('tipotitulo', 'choice', array(
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
          ->add('idtitulo', null, array('label' => 'Titulo'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
          ->addIdentifier('idtitulo', null,array('label' => 'Titulo'))                   
        ;
    }

    public function configureRoutes(RouteCollection $collection){
    $collection->clearExcept(array('show','create'));
    }
    
}
