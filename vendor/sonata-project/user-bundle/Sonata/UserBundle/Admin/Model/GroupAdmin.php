<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\UserBundle\Admin\Model;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GroupAdmin extends Admin
{
    protected $formOptions = array(
        'validation_groups' => 'Registration'
    );
    protected $baseRoutePattern = 'grupo';
    /**
     * {@inheritdoc}
     */
    public function getNewInstance()
    {
        $class = $this->getClass();

        return new $class('', array());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name',null, array('route' => array('name' => 'show')))
            ->add('roles')
            ->add('idacceso', null, array('label'=>'Opciones'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('idacceso', null, array('label'=>'Opciones'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('roles', 'sonata_type_roles', array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'label' => 'Asigar rol',
            ))
           ->add('idacceso','sonata_type_model',array('required'=>false,'multiple'=>true,'expanded'=>true ,'label'=>'Opciones')) 
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'Nombre Rol'))
            ->add('idacceso',null,array('label'=>'Opciones')) 
        ;
     }
}
