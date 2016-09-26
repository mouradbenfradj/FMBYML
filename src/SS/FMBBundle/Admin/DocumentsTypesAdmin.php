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


class DocumentsTypesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('idTypeDoc')->add('libTypeDoc')->add('libTypePrinted')->add('codeDoc')->add('idTypeGroupe')->add('actif')->add('idPdfModele');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('idTypeDoc')->add('libTypeDoc')->add('libTypePrinted')->add('codeDoc')->add('idTypeGroupe')->add('actif')->add('idPdfModele');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('idTypeDoc')->add('libTypeDoc')->add('libTypePrinted')->add('codeDoc')->add('idTypeGroupe')->add('actif')->add('idPdfModele');
    }
}