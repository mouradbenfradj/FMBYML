<?php

namespace SS\FMBBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ParcRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParcRepository extends EntityRepository
{
    public function findAllParc()
    {
        $qb = $this->createQueryBuilder('m')
            ->select(array('m.idMagasin', 'm.abrevMagasin'));
        return $qb->getQuery()->getResult();
    }

    public function countTotaleNbrFiliere()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(f)')
            ->join('m.filieres', 'f');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeHuitreAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere("c.nomCorde LIKE '%CORDE H%'")
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeHMoulesAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere("c.nomCorde LIKE '%CORDE M%'")
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeChausseeAE()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.chaussement = :chaussement')
            ->andWhere('sc.pret = :pres')
            ->setParameter('chaussement', true)
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAssembleAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NOT NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeHuitrePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere("c.nomCorde LIKE '%CORDE H%'")
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeMoulePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere("c.nomCorde LIKE '%CORDE M%'")
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAssemble()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.dateAssemblage IS NOT NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeEnStock()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('SUM(c.nbrTotaleEnStock)')
            ->join('m.cordes', 'c');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NOT NULL')
            ->andWhere('sl.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneChausserAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NOT NULL')
            ->andWhere('sl.chaussement = :chaussement')
            ->andWhere('sl.pret = :pres')
            ->setParameter('chaussement', true)
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanternePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NULL')
            ->andWhere('sl.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneEnStock()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('SUM(l.nbrTotaleEnStock)')
            ->join('m.lanternes', 'l');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheChausserAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.chaussement = :chaussement')
            ->andWhere('sp.pret = :pres')
            ->setParameter('chaussement', true)
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAssembleAEau()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.cordeAssemblage IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NOT NULL')
            ->andWhere('sp.dateDeMiseAEau IS NOT NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPochePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAssemblePreparer()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NULL')
            ->andWhere('sp.dateAssemblage IS NOT NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheEnStock()
    {

        $qb = $this->createQueryBuilder('m')
            ->select('SUM(p.nbrTotaleEnStock)')
            ->join('m.poches', 'p');
        return $qb->getQuery()->getSingleScalarResult();
    }


    public function countTotaleNbrFiliereByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(f)')
            ->join('m.filieres', 'f')
            ->where('f.parc = :parc')
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeHuitreAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->andWhere("c.nomCorde LIKE '%CORDE H%'")
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeMouleAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->andWhere("c.nomCorde LIKE '%CORDE M%'")
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeChausserAEByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->andWhere('sc.chaussement = :chaussement')
            ->andWhere('sc.pret = :pres')
            ->setParameter('chaussement', true)
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAssembleAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NOT NULL')
            ->andWhere('sc.dateAssemblage IS NOT NULL')
            ->andWhere('sc.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->setParameter('parc', $parc);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordePreparerByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeHuitrePreparerByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->andWhere("c.nomCorde LIKE '%CORDE H%'")
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeMoulePreparerByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere('sc.dateAssemblage IS NULL')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->andWhere("c.nomCorde LIKE '%CORDE M%'")
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeAssembleByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sc)')
            ->join('m.cordes', 'c')
            ->leftJoin('c.stockscordes', 'sc')
            ->where('sc.emplacement IS NULL')
            ->andWhere('sc.pret = :pres')
            ->andWhere('sc.dateAssemblage IS NOT NULL')
            ->setParameter('pres', false)
            ->andWhere('c.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrCordeEnStockByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('SUM(c.nbrTotaleEnStock)')
            ->join('m.cordes', 'c')
            ->where('c.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NOT NULL')
            ->andWhere('sl.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('l.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneChausserAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NOT NULL')
            ->andWhere('sl.pret = :pres')
            ->andWhere('sl.chaussement = :chaussement')
            ->setParameter('pres', false)
            ->andWhere('l.parc = :parc')
            ->setParameter('chaussement', true)
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanternePreparerByParc($parc)
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sl)')
            ->join('m.lanternes', 'l')
            ->leftJoin('l.stockslanternes', 'sl')
            ->where('sl.emplacement IS NULL')
            ->andWhere('sl.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('l.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrLanterneEnStockByParc($parc)
    {

        $qb = $this->createQueryBuilder('m')
            ->select('SUM(l.nbrTotaleEnStock)')
            ->join('m.lanternes', 'l')
            ->where('l.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('p.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheChausserAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.pret = :pres')
            ->andWhere('sp.chaussement = :chaussement')
            ->setParameter('pres', false)
            ->andWhere('p.parc = :parc')
            ->setParameter('chaussement', true)
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAssembleAEauByParc($parc)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.cordeAssemblage IS NOT NULL')
            ->andWhere('sp.dateAssemblage IS NOT NULL')
            ->andWhere('sp.dateDeMiseAEau IS NOT NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('p.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPochePreparerByParc($parc)
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NULL')
            ->andWhere('sp.dateAssemblage IS NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('p.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheAssemblePreparerByParc($parc)
    {

        $qb = $this->createQueryBuilder('m')
            ->select('COUNT(sp)')
            ->join('m.poches', 'p')
            ->leftJoin('p.stockspoches', 'sp')
            ->where('sp.emplacement IS NULL')
            ->andWhere('sp.dateAssemblage IS NOT NULL')
            ->andWhere('sp.pret = :pres')
            ->setParameter('pres', false)
            ->andWhere('p.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countTotaleNbrPocheEnStockByParc($parc)
    {

        $qb = $this->createQueryBuilder('m')
            ->select('SUM(p.nbrTotaleEnStock)')
            ->join('m.poches', 'p')
            ->where('p.parc = :parc')
            ->setParameter('parc', $parc);
        return $qb->getQuery()->getSingleScalarResult();
    }
}
