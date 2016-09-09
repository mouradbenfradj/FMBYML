<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\DocumentsTypes;

class LoadDocumentsTypes implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $typePL = new DocumentsTypes();
        $typePL->setActif(true);
        $typePL->setCodeDoc('00001');
        $typePL->setIdTypeGroupe(true);
        $typePL->setLibTypeDoc('preparation');
        $typePL->setLibTypePrinted('preparation');

        $manager->persist($typePL);
        $typePC = new DocumentsTypes();
        $typePC->setActif(true);
        $typePC->setCodeDoc('0002');
        $typePC->setIdTypeGroupe(true);
        $typePC->setLibTypeDoc('preparation');
        $typePC->setLibTypePrinted('preparation');
        $manager->persist($typePC);

        $manager->flush();
    }
}
