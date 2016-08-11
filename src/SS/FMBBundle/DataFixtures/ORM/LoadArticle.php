<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Articles;

class LoadArticle extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $NaissainHuitre = new Articles();
        $NaissainHuitre->setLibArticle('Naissain Huitre');
        $NaissainHuitre->setRefArticle('NH');
        $NaissainHuitre->setLot($this->getReference('lot'));
        $manager->persist($NaissainHuitre);

        $manager->flush();
        $this->addReference('Huitre', $Huitre);
        $this->addReference('Moule', $Moule);
        $this->addReference('NaissainHuitre', $NaissainHuitre);
        $this->addReference('NaissainMoule', $NaissainMoule);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }

}