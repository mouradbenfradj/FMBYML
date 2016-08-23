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
        $NaissainHuitre->setRefArticle('0001');
        $NaissainHuitre->setLot($this->getReference('lot'));
        $manager->persist($NaissainHuitre);
        $NaissainHuitre1 = new Articles();
        $NaissainHuitre1->setLibArticle('Naissain Huitre');
        $NaissainHuitre1->setRefArticle('0002');
        $NaissainHuitre1->setLot($this->getReference('lo'));
        $manager->persist($NaissainHuitre1);
        $NaissainHuitre2 = new Articles();
        $NaissainHuitre2->setLibArticle('Naissain Huitre');
        $NaissainHuitre2->setRefArticle('0003');
        $NaissainHuitre2->setLot($this->getReference('l'));
        $manager->persist($NaissainHuitre2);

        $manager->flush();
        $this->addReference('NaissainHuitre1', $NaissainHuitre1);
        $this->addReference('NaissainHuitre2', $NaissainHuitre2);
        $this->addReference('NaissainHuitre', $NaissainHuitre);
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