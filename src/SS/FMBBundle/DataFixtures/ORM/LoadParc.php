<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Parc;

class LoadParc extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fmb = new Parc();
        $fmb->setNomParc('FMB');
        $manager->persist($fmb);
        $FMBMTH = new Parc();
        $FMBMTH->setNomParc('FMBMTH');
        $manager->persist($FMBMTH);
        $Marinor = new Parc();
        $Marinor->setNomParc('Marinor');
        $manager->persist($Marinor);

        $manager->flush();
        $this->addReference('fmb', $fmb);
        $this->addReference('FMBMTH', $FMBMTH);
        $this->addReference('Marinor', $Marinor);
    }
}