<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Lot;

class LoadLot extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lot = new Lot();
        $lot->setLot('NH30');
        $manager->persist($lot);
        $lo = new Lot();
        $lo->setLot('NH33');
        $manager->persist($lot);
        $l = new Lot();
        $l->setLot('NH32');
        $manager->persist($lot);

        $manager->flush();
        $this->addReference('lot', $lot);
        $this->addReference('lo', $lo);
        $this->addReference('l', $l);
    }
}