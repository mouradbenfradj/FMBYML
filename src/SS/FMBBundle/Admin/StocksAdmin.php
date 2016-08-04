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


class StocksAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('libStock')->add('refAdrStock')->add('actif');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('libStock')->add('refAdrStock')->add('actif');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('libStock')->addIdentifier('refAdrStock')->addIdentifier('actif');
    }
}