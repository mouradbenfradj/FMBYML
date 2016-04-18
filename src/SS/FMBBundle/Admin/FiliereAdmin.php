<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 01/04/2016
 * Time: 00:38
 */

namespace SS\FMBBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class FiliereAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('parc')
            ->add('nomFiliere', 'text')
            ->add(
                'segments',
                'sonata_type_collection',
                array(
                    'required' => true,
                    'by_reference' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'id',
                )
            );


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nomFiliere');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('parc');
        $listMapper->addIdentifier('nomFiliere');
        $listMapper->addIdentifier('segments');

    }
}