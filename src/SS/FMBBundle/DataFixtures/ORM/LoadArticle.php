<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Articles;

class LoadArticle implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $nomArticle = array(
            'Huitre',
            'Moule',
            'Naissain Huitre',
            'Naissain Moule',
        );
        foreach ($nomArticle as $name) {
            $article = new Articles();
            $article->setLibArticle($name);
            $manager->persist($article);
        }
        $manager->flush();
    }
}