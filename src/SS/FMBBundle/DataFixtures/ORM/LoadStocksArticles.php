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
        $stockArNH->setQte(1000);
        $stockArNH->setRefStockArticle('00001');
        $stockArNH->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNH);
        $stockArNM = new StocksArticles();
        $stockArNM->setRefArticle($this->getReference('NaissainMoule'));
        $stockArNM->setQte(500);
        $stockArNM->setRefStockArticle('00002');
        $stockArNM->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNM);
        $manager->flush();
        $this->addReference('stockArNH', $stockArNH);
        $this->addReference('stockArNM', $stockArNM);
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