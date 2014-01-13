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


        $em = $this->modelManager->getEntityManager('ExpedienteBundle:Titulo');

        $queryt = $em->createQueryBuilder('t')
                     ->select('t')
                     ->from('ExpedienteBundle:Titulo', 't')
                     ->orderBy('t.nombretitulo', 'ASC');


        $em = $this->modelManager->getEntityManager('AdminBundle:Conocimiento');

        $queryc = $em->createQueryBuilder('c')
                     ->select('c')
                     ->from('AdminBundle:Conocimiento', 'c')
                     ->orderBy('c.nombreconocimiento', 'ASC');

        $em = $this->modelManager->getEntityManager('AdminBundle:Habilidad');

        $queryh = $em->createQueryBuilder('h')
                     ->select('h')
                     ->from('AdminBundle:Habilidad', 'h')
                     ->orderBy('h.nombrehabilidad', 'ASC');

        $em = $this->modelManager->getEntityManager('AdminBundle:Manejoequipo');

        $querym = $em->createQueryBuilder('m')
                     ->select('m')
                     ->from('AdminBundle:Manejoequipo', 'm')
                     ->orderBy('m.nombremanejo', 'ASC');

       $formMapper
           ->with('General')    
            ->add('nombreplaza', null, array('label' => 'Plaza','help'=>'Digite el nombre de la plaza'))
            ->add('descripcionplaza', 'textarea', array('label' => 'Descripción','help'=>'Ingrese una descripción para la plaza'))
            ->add('edad', 'integer', array('max_length'=>'2','label' => 'Edad requerida', 'help'=>'Ingrese la edad requerida'))
            ->add('experiencia', 'integer', array('max_length'=>'2','label' => 'Experiencia requerida', 'help'=>'Ingrese una cantidad en años'))
            ->add('sexo', 'choice', array('choices'   => array('M' => 'Masculino', 'F' => 'Femenino','A'=>'Ambos'),'empty_value'=>'Seleccione...','required'  => true, 'label'=>'Sexo'))
            ->add('idarea','sonata_type_model',array('required'=>'required', 'label'=>'Area'))
            ->add('estadoplaza', 'choice', array('choices'   => array('A' => 'Activa', 'I' => 'Inactiva'),'required'  => true, 'label'=>'Estado'))
           ->end()
           ->with('Titulo', array('description' => 'Selección de titulos.'))
             ->add('idtitulo', 'sonata_type_model', array(
                   'required'=>true,
                   'label'=> 'Titulos',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryt
                   ))
           ->end()
           ->with('Funciones',array('description'=> 'Selección de funciones.'))
             ->add('idfuncion', 'pcdummy_ajaxcomplete_m2m', array(
                   'required'=>true,
                   'label'=> 'Funciones',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   ))
           ->end()
           ->with('Conocimientos', array('description' => 'Selección de conocimientos.'))
              ->add('idconocimiento', 'sonata_type_model', array(
                   'required'=>true,
                   'label'=> 'Conocimientos',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryc
                   ))
           ->end()
           ->with('Habilidades', array('description' => 'Selección de habilidades.'))
              ->add('idhabilidad', 'sonata_type_model', array(
                   'required'=>false,
                   'label'=> 'Habilidades',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$queryh
                   ))
           ->end()
           ->with('Manejo de Equipo', array('description' => 'Selección de manejo de equipo.'))
              ->add('idmanejoequipo', 'sonata_type_model', array(
                   'required'=>false,
                   'label'=> 'Manejo de equipo',
                   'required' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'query'    =>$querym
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
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea', null, array('label' => 'Area'))
        ;
    }
    
        //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombreplaza',null,array('label'=>'Plaza','route' => array('name' => 'show')))
            ->add('descripcionplaza', null, array('label' => 'Descripción'))
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea', 'textarea', array('label' => 'Area',))

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
            ->add('descripcionplaza', 'textarea', array('label' => 'Descripción'))
            ->add('edad', null, array('label' => 'Edad requerida'))
            ->add('sexo')
            ->add('estadoplaza', null, array('label'=>'Estado'))
            ->add('idarea',null,array('label'=>'Area'))
           ->end()
           ->with('Titulo (s)')
             ->add('idtitulo',null,array('label'=>'Titulo Requerido'))
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
           ->with('Documentación')
             ->add('name',null, array('label'=>'Nombre documento'))
             ->add('path', 'string',array('label'=>'Documento','template' => 'AdminBundle:CRUD:documentos.html.twig'))
             ->add('observaciones',null, array('label'=>'Observaciones'))
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