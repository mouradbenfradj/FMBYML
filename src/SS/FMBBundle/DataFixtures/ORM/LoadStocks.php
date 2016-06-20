<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Stocks;

class LoadStocks extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $stock1 = new Stocks();
        $stock1->setLibStock('stock1');
        $stock1->setAbrevStock('st1');
        $stock1->setActif(true);
        $stock1->setRefAdrStock($this->getReference('fmb'));
        $manager->persist($stock1);
        $manager->flush();
        $this->addReference('stock1', $stock1);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 6;
    }

}