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


class DocumentsEtatsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('idEtatDoc')->add('libEtatDoc')->add('ordre')->add('isOpen')->add('idTypeDoc');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('idEtatDoc')->add('libEtatDoc')->add('ordre')->add('isOpen')->add('idTypeDoc');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('idEtatDoc')->add('libEtatDoc')->add('ordre')->add('isOpen')->add('idTypeDoc');
    }
}
