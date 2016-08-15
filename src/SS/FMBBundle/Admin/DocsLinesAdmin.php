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


class DocsLinesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refDocLine')->add('refDoc')->add('refArticle')->add('libArticle')->add('descArticle')->add('qte');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refDocLine')->add('refDoc')->add('refArticle')->add('libArticle')->add('descArticle')->add('qte');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refDocLine')->addIdentifier('refDoc')->addIdentifier('refArticle')->addIdentifier('libArticle')->addIdentifier('descArticle')->addIdentifier('qte');
    }
}