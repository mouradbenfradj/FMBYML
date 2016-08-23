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


class StocksLanternesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id')->add('lanterne')->add('poches')->add('emplacement')->add('pret')->add('article')->add('dateDeCreation')->add('docLine');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')->add('lanterne')->add('poches')->add('emplacement')->add('pret')->add('article')->add('dateDeCreation')->add('docLine');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->add('lanterne')->add('poches')->add('emplacement')->add('pret')->add('article')->add('dateDeCreation')->add('docLine');
    }
}