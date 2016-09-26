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


class AdressesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refAdresse')->add('libAdresse')->add('textAdresse')->add('codePostal')->add('ville')->add('note')->add('ordre')->add('idTypeAdresse')->add('idPays')->add('refContact');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refAdresse')->add('libAdresse')->add('textAdresse')->add('codePostal')->add('ville')->add('note')->add('ordre')->add('idTypeAdresse')->add('idPays')->add('refContact');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refAdresse')->add('libAdresse')->add('textAdresse')->add('codePostal')->add('ville')->add('note')->add('ordre')->add('idTypeAdresse')->add('idPays')->add('refContact');
    }
}