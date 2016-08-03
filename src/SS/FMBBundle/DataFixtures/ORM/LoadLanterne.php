<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Lanterne;

class LoadLanterne extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lant7p = new Lanterne();
        $lant7p->setNomLanterne('lant7p');
        $lant7p->setNbrpoche(7);
        $manager->persist($lant7p);
        $lant10p = new Lanterne();
        $lant10p->setNomLanterne('lant10p');
        $lant10p->setNbrpoche(10);
        $manager->persist($lant10p);
        $pearlnet = new Lanterne();
        $pearlnet->setNomLanterne('pearlnet');
        $pearlnet->setNbrpoche(1);
        $manager->persist($pearlnet);

        $manager->flush();
        $this->addReference('lant7p', $lant7p);
        $this->addReference('lant10p', $lant10p);
        $this->addReference('pearlnet', $pearlnet);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }

}