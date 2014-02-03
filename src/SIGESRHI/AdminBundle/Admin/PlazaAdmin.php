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


        $em = $this->modelManager->getEntityManager('AdminBundle:Resultados');

        $queryr = $em->createQueryBuilder('r')
                     ->select('r')
                     ->from('AdminBundle:Resultados', 'r')
                     ->orderBy('r.nombreresultado', 'ASC');


        $em = $this->modelManager->getEntityManager('AdminBundle:Conocimiento');

        $queryo = $em->createQueryBuilder('o')
                     ->select('o')
                     ->from('AdminBundle:Otrosaspectos', 'o')
                     ->orderBy('o.nombreotrosaspectos', 'ASC');

        $em = $this->modelManager->getEntityManager('AdminBundle:Competencia');

        $queryc = $em->createQueryBuilder('c')
                     ->select('c')
                     ->from('AdminBundle:Competencia', 'c')
                     ->orderBy('c.nombrecompetencia', 'ASC');

        $em = $this->modelManager->getEntityManager('AdminBundle:Marcoreferencia');

        $querym = $em->createQueryBuilder('m')
                     ->select('m')
                     ->from('AdminBundle:Marcoreferencia', 'm')
                     ->orderBy('m.nombremarcoref', 'ASC');

       $formMapper
           ->with('General')    
            ->add('nombreplaza', null, array('label' => 'Plaza','help'=>'Digite el nombre de la plaza'))
            ->add('misionplaza', 'textarea', array('label' => 'Misión','help'=>'Ingrese la misión del puesto de trabajo'))
            ->add('unidad', null, array('label'=>'Unidad organizativa','help'=>'Ingrese la(s) unidade(s) organizativa(s) a la que pertenece'))
            ->add('experiencia', 'integer', array('max_length'=>'2','required'=>false,'label' => 'Experiencia requerida', 'help'=>'Ingrese una cantidad en años'))  
            ->add('idplazasup',null,array('label' => 'Plaza superior','help'=>'Seleccione la plaza de la cual depende, si la hay'))
           ->end()
           ->with('Marco de referencia', array('description' => 'Marco de referencia para la actuación.'))
              ->add('idmarcoreferencia', 'sonata_type_model', array(
                   'label'=> 'Marco de referencia',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$querym
                   ))
           ->end()
           ->with('Funciones',array('description'=> 'Funciones/Actividades básicas.'))
             ->add('idfuncion', 'pcdummy_ajaxcomplete_m2m', array(
                   'required'=>true,
                   'label'=> 'Funciones',
                   'expanded' => true,
                   'multiple' => true,
                   'help'=>'Digite para buscar una función'
                   ))
           ->end()
           ->with('Resultados',array('description'=> 'Resultados esperados.'))
             ->add('idresultado', 'sonata_type_model', array(
                   'required'=>true,
                   'label'=> 'Resultados esperados',
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryr
                   ))
           ->end()
           ->with('Formación Académica', array('description' => 'Selección de titulos.'))
             ->add('idtituloplaza', 'sonata_type_collection', 
             array('by_reference'=>false,'required'=>false,'label'=>'Titulos'), 
             array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
           ->end()
           ->with('Otros idiomas', array('description' => 'Otros idiomas.'))
             ->add('ididiomasplaza', 'sonata_type_collection', 
             array('by_reference'=>false,'required'=>false,'label'=>'Idiomas'), 
             array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
           ->end()
           ->with('Conocimientos', array('description' => 'Conocimientos especificos.'))
             ->add('idconocimientoplaza', 'sonata_type_collection', 
             array('by_reference'=>false,'required'=>false,'label'=>'Conocimientos'), 
             array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
           ->end()
           ->with('Competencias', array('description' => 'Competencias conductuales.'))
              ->add('idcompetencia', 'sonata_type_model', array(
                   'required'=>false,
                   'label'=> 'Competencias',
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryc
                   ))
           ->end()
           ->with('Otros aspectos', array('description' => 'Otros aspectos.'))
              ->add('idotrosaspectos', 'sonata_type_model', array(
                   'required'=>false,
                   'label'=> 'Otros aspectos',
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryo
                   ))
           ->end()
           ->with('Documentación', array('description' => 'En esta sección tiene la posibilidad de adjuntar el documento necesario (imagen o pdf) que respalde la acción realizada sobre la plaza.'))
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
            ->add('idplazasup', null, array('label'=>'Plaza superior'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreplaza',null,array('label'=>'Plaza','route' => array('name' => 'show')))
            ->add('misionplaza', null, array('label' => 'Misión del puesto'))

          /* ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                )
            )) */
        ;
    }
    
   protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Generales')     
              ->add('nombreplaza', null, array('label' => 'Plaza'))
              ->add('misionplaza', 'textarea', array('label' => 'Misión del puesto'))
              ->add('unidad', null, array('label'=>'Unidad organizativa'))
              ->add('idplazasup','entity',array('label'=>'Plaza de la que depende'))
           ->end()
           ->with('Marco de referencia para la actuación.')
              ->add('idmarcoreferencia', null, array('label'=> 'Marco de referencia'))
           ->end()
           ->with('Funciones/Actividades básicas.')
             ->add('idfuncion', null, array('label'=> 'Funciones'))
           ->end()
           ->with('Resultados esperados.')
             ->add('idresultado', null, array('label'=> 'Resultados esperados'))
           ->end()
           ->with('Formación Académica')
             ->add('idtituloplaza', null, array('label'=>'Formación académica'))
           ->end()
           ->with('Otros idiomas')
             ->add('ididiomasplaza',null, array('label'=>'Otros idiomas'))
           ->end()
           ->with('Conocimientos especificos')
             ->add('idconocimientoplaza',null, array('label'=>'Conocimientos especificos'))
           ->end()
           ->with('Competencias conductuales.')
              ->add('idcompetencia', null, array('label'=> 'Competencias'))
           ->end()
           ->with('Otros aspectos')
              ->add('idotrosaspectos', null, array('label'=> 'Otros aspectos'))
           ->end()
           ->with('Documentación')
             ->add('name',null, array('label'=>'Nombre documento'))
             ->add('path', 'string',array('label'=>'Documento','template' => 'AdminBundle:CRUD:documentos.html.twig'))
             ->add('observaciones',null, array('label'=>'Observaciones'))
           ->end()
        ;
    }
    
    public function prePersist($plaza) {
       $this->saveFile($plaza);
       $this->preUpdate($plaza);
    }

    public function preUpdate($plaza) {
       $this->saveFile($plaza);
       $plaza->setIdtituloplaza($plaza->getIdtituloplaza());
       $plaza->setIdidiomasplaza($plaza->getIdidiomasplaza());
       $plaza->setIdconocimientoplaza($plaza->getIdconocimientoplaza());
    }

    public function saveFile($plaza) {
        $basepath=$this->getRequest()->getBasePath();
        $plaza->upload($basepath);    
        $plaza->refreshUpdated();
        }
}