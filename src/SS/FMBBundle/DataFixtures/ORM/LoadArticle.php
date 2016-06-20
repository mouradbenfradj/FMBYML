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
        $Huitre = new Articles();
        $Huitre->setLibArticle('Huitre');
        $Huitre->setRefArticle('test1');
        $Huitre->setLot($this->getReference('lot'));
        $manager->persist($Huitre);
        $Moule = new Articles();
        $Moule->setLibArticle('Moule');
        $Moule->setRefArticle('test2');
        $Moule->setLot($this->getReference('lot'));
        $manager->persist($Moule);
        $NaissainHuitre = new Articles();
        $NaissainHuitre->setLibArticle('Naissain Huitre');
        $NaissainHuitre->setRefArticle('test3');
        $NaissainHuitre->setLot($this->getReference('lot'));
        $manager->persist($NaissainHuitre);
        $NaissainMoule = new Articles();
        $NaissainMoule->setLibArticle('Naissain Moule');
        $NaissainMoule->setRefArticle('test4');
        $NaissainMoule->setLot($this->getReference('lot'));
        $manager->persist($NaissainMoule);

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