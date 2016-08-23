<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\StocksArticles;

class LoadStocksArticles extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $stockArNH = new StocksArticles();
        $stockArNH->setRefArticle($this->getReference('NaissainHuitre'));
        $stockArNH->setQte(10000000);
        $stockArNH->setRefStockArticle('00001');
        $stockArNH->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNH);
        $stockArNM = new StocksArticles();
        $stockArNM->setRefArticle($this->getReference('NaissainHuitre1'));
        $stockArNM->setQte(50000000);
        $stockArNM->setRefStockArticle('00002');
        $stockArNM->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNM);
        $stockArNH2 = new StocksArticles();
        $stockArNH2->setRefArticle($this->getReference('NaissainHuitre2'));
        $stockArNH2->setQte(2000000);
        $stockArNH2->setRefStockArticle('00003');
        $stockArNH2->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNH2);
        $manager->flush();
        $this->addReference('stockArNH', $stockArNH);
        $this->addReference('stockArNM', $stockArNM);
        $this->addReference('stockArNH2', $stockArNH2);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }

}