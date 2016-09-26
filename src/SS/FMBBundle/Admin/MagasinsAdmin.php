<?php
namespace SS\FMBBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MagasinsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('idMagasin')->add('libMagasin')->add('abrevMagasin')->add('modeVente')->add('actif')->add('idMagEnseigne')->add('filieres')->add('idTarif')->add('idStock');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('idMagasin')->add('libMagasin')->add('abrevMagasin')->add('modeVente')->add('actif')->add('idMagEnseigne')->add('filieres')->add('idTarif')->add('idStock');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('idMagasin')->add('libMagasin')->add('abrevMagasin')->add('modeVente')->add('actif')->add('idMagEnseigne')->add('filieres')->add('idTarif')->add('idStock');
    }
}
