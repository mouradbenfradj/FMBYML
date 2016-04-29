<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Parc;

class LoadParc implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $nomParc = array(
            'FMB',
            'FMBMTH',
            'Marinor',
        );

        foreach ($nomParc as $name) {
            // On crée la catégorie
            $parc = new Parc();
            $parc->setNomParc($name);

            // On la persiste
            $manager->persist($parc);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}