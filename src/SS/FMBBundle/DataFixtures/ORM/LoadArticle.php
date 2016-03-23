<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Proxies\__CG__\SS\FMBBundle\Entity\Article;

class LoadArticle implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $nomArticle = array(
            'Huitre',
            'Moule',
        );

        foreach ($nomArticle as $name) {
            // On crée la catégorie
            $article = new Article();
            $article->setNomArticle($name);

            // On la persiste
            $manager->persist($article);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}