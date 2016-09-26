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


class AnnuaireAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refContact')->add('nom')->add('siret')->add('tvaIntra')->add('note')->add('dateCreation')->add('dateModification')->add('dateArchivage')->add('idCategorie')->add('idCivilite');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refContact')->add('nom')->add('siret')->add('tvaIntra')->add('note')->add('dateCreation')->add('dateModification')->add('dateArchivage')->add('idCategorie')->add('idCivilite');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refContact')->add('nom')->add('siret')->add('tvaIntra')->add('note')->add('dateCreation')->add('dateModification')->add('dateArchivage')->add('idCategorie')->add('idCivilite');
    }
}

