<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\TypeDocuments;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $typePL = new TypeDocuments();
        $typePL->setArticle('lanterne');
        $typePL->setRole('preparation');
        $manager->persist($typePL);
        $typePC = new TypeDocuments();
        $typePC->setArticle('corde');
        $typePC->setRole('preparation');
        $manager->persist($typePC);
        $manager->flush();
    }
}
