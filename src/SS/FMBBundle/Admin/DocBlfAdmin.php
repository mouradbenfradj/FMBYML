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


class DocBlfAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refDoc')->add('refDocExterne')->add('idStock');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refDoc')->add('refDocExterne')->add('idStock');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refDoc')->addIdentifier('refDocExterne')->addIdentifier('idStock');
    }
}