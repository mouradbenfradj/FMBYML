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


class ArticlesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refArticle')->add('libArticle')->add('idValo')->add('idModeleSpe')->add('isVendable')->add('isAchetable')->add('numeroCompteVente')->add('numeroCompteAchat')->add('dateModification')->add('dateCreation')->add('dispo')->add('dateFinDispo')->add('dateDebutDispo')->add('gestionSn')->add('variante')->add('composant')->add('lot')->add('valoIndice')->add('promo')->add('idTva')->add('paaLastMaj')->add('paaHt')->add('prixAchatHt')->add('prixPublicHt')->add('refConstructeur')->add('modele')->add('refArtCateg')->add('descLongue')->add('descCourte')->add('libTicket')->add('refInterne')->add('refOem');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refArticle')->add('libArticle')->add('idValo')->add('idModeleSpe')->add('isVendable')->add('isAchetable')->add('numeroCompteVente')->add('numeroCompteAchat')->add('dateModification')->add('dateCreation')->add('dispo')->add('dateFinDispo')->add('dateDebutDispo')->add('gestionSn')->add('variante')->add('composant')->add('lot')->add('valoIndice')->add('promo')->add('idTva')->add('paaLastMaj')->add('paaHt')->add('prixAchatHt')->add('prixPublicHt')->add('refConstructeur')->add('modele')->add('refArtCateg')->add('descLongue')->add('descCourte')->add('libTicket')->add('refInterne')->add('refOem');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refArticle')->add('libArticle')->add('paaLastMaj')->add('lot')->add('dateModification')->add('dateCreation')->add('dispo')->add('dateFinDispo')->add('dateDebutDispo')->add('gestionSn')->add('variante')->add('composant')->add('isVendable')->add('isAchetable');
    }
}