<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 01/04/2016
 * Time: 00:01
 */

namespace SS\FMBBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SegmentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nomSegment')
            ->add('longeur');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')->add('filiere.parc')->add('filiere')->add('nomSegment')->add('longeur');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('filiere.parc')->add('id')->add('filiere')->add('nomSegment')->add('longeur');
    }
}