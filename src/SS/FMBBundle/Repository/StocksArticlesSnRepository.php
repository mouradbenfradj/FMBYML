<?php

namespace SS\FMBBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StocksLanternesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StocksArticlesSnRepository extends EntityRepository
{
    public function getSAS($refStocksArticles, $numeroSerie)
    {
        $qb = $this->createQueryBuilder('sas');
        $qb->where('sas.refStockArticle = ?1')
            ->setParameter(1, $refStocksArticles)
            ->andWhere('sas.numeroSerie = ?2')
            ->setParameter(2, $numeroSerie);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
