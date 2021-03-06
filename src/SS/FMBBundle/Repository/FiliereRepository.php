<?php

namespace SS\FMBBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SS\FMBBundle\Entity\Magasins;

/**
 * FiliereRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FiliereRepository extends EntityRepository
{
    public function getTotaleContenuFiliere(Magasins $parc)
    {
        $qb = $this->createQueryBuilder('fi')
            ->select('fl.id as flId')
            ->addSelect('fi.aireDeTravaille')
            ->addSelect('fi.observation as observation')
            ->addSelect('lanter.nbrpoche')
            ->addSelect('s.longeur')
            ->addSelect('e.dateDeRemplissage as dateDeRemplissage')
            ->addSelect('fi.id as fiId')
            ->addSelect('s.id as sId')
            ->addSelect('e.id as empId')
            ->addSelect('c.id as sc')
            ->addSelect('lan.id as sl')
            ->addSelect('procl.numeroDebCycle as numDebCyclel')
            ->addSelect('procl.abrevProcessus as abrevProcessusl')
            ->addSelect('procl.couleur as couleurl')
            ->addSelect('procl.couleurDuFond as couleurDuFondl')
            ->addSelect('procl.duree as dureecyclel')
            ->addSelect('procl.alerteJaune as alerteJcyclel')
            ->addSelect('procl.alerteRouge as alerteRcyclel')
            ->addSelect('procl.articleSortie as sarticlel')

            ->addSelect('procc.numeroDebCycle as numDebCyclec')
            ->addSelect('procc.abrevProcessus as abrevProcessusc')
            ->addSelect('procc.couleur as couleurc')
            ->addSelect('procc.couleurDuFond as couleurDuFondc')
            ->addSelect('procc.duree as dureecyclec')
            ->addSelect('procc.alerteJaune as alerteJcyclec')
            ->addSelect('procc.alerteRouge as alerteRcyclec')
            ->addSelect('procc.articleSortie as sarticlec')

            ->addSelect('procl.id as processusl')
            ->addSelect('procc.id as processusc')
            ->addSelect('procp.id as processusp')
            ->addSelect('spchbs.id as sp')
            ->addSelect('fi.nomFiliere')
            ->addSelect('s.nomSegment')
            ->addSelect('fl.nomFlotteur')
            ->addSelect('cord.nomCorde')
            ->addSelect('lanter.nomLanterne')
            ->addSelect('e.place')
            ->addSelect('lart.numeroSerie as numeroSerieLanrt')
            ->addSelect('carticle.numeroSerie as numeroSerie ')
            ->addSelect('part.numeroSerie as numeroSeriePoche')
            ->addSelect('c.chaussement as chausc')
            ->addSelect('spchbs.chaussement as chausp')
            ->addSelect('lan.chaussement as chausl')
            ->addSelect('refa.libArticle as libArticle')
            ->addSelect('reflart.libArticle as llibArticle')
            ->addSelect('refpart.libArticle as plibArticle')
            ->addSelect('c.dateDeMAETransfert as maect')
            ->addSelect('spchbs.dateDeMAETransfert as maept')
            ->addSelect('lan.dateDeMAETransfert as maelt')
            ->addSelect('c.quantiter as qtec')
            ->addSelect('c.dateAssemblage as dateAssemblage')
            ->addSelect('poch.quantite as qte')

            ->join('fi.segments', 's')
            ->join('s.flotteurs', 'fl')
            ->join('fl.emplacements', 'e')
            ->leftJoin('e.stockslanterne', 'lan')
            ->leftJoin('e.stockscorde', 'c')
            ->leftJoin('e.stockspoches', 'spchbs')
            ->leftJoin('spchbs.pochesbs', 'pchbs')
            ->leftJoin('spchbs.article', 'part')
            ->leftJoin('part.refStockArticle', 'refpsart')
            ->leftJoin('refpsart.refArticle', 'refpart')
            ->leftJoin('lan.lanterne', 'lanter')
            ->leftJoin('lan.poches', 'poch')
            ->leftJoin('lan.article', 'lart')
            ->leftJoin('lart.refStockArticle', 'reflsart')
            ->leftJoin('reflsart.refArticle', 'reflart')
            ->leftJoin('c.corde', 'cord')
            ->leftJoin('c.article', 'carticle')
            ->leftJoin('carticle.refStockArticle', 'refsa')
            ->leftJoin('refsa.refArticle', 'refa')
            ->leftJoin('spchbs.processus', 'procp')
            ->leftJoin('c.processus', 'procc')
            ->leftJoin('lan.processus', 'procl')
            ->where('fi.parc = :parc')
            ->orderBy('fi.nomFiliere', 'ASC')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getResult();
    }
}
