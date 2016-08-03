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


class LanterneAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('parc')->add('nomLanterne')->add('duplication')->add('nbrpoche');

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('parc')->add('nomLanterne')->add('duplication')->add('nbrpoche');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('parc')->add('nomLanterne')->add('duplication')->add('nbrpoche');
    }
}