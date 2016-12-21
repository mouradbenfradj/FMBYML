<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:09
 */

namespace SS\FMBBundle\Implementation;


use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Entity\Poche;
use SS\FMBBundle\Interfaces\DefaultInterface;

class DefaultImpl implements DefaultInterface
{
    protected $em;

    public function __construct($entitymanager)
    {
        $this->em = $entitymanager;
    }

    public function calculerQuantiterLanterne($tableauPoches)
    {
        $somme = 0;
        foreach ($tableauPoches->getPoches() as $poches) {
            $somme = $somme + $poches->getQuantite();
        }

        if ($somme != 0) {
            return $somme;
        }
    }

    public function viderPoche($poche, $qte)
    {
        // TODO: Implement viderPoche() method.
    }

    public function modifierQtePoche($poche, $qte)
    {
        // TODO: Implement modifierQtePoche() method.
    }

    public function remplirPoche($i, $qte, $nbrPocheLanterne)
    {
        $poche = new Poche();
        $poche->setEmplacement($i);
        if ($i == 1) {
            $poche->setQuantite(((int)($qte / $nbrPocheLanterne)) + ((int)($qte % $nbrPocheLanterne)));
        } else {
            $poche->setQuantite((int)($qte / $nbrPocheLanterne));
        }
        return $poche;
    }

    public function ordonnanceurTableau($filieres)
    {
        //11978
        $tableau = $this->distainctTable($filieres, 'fiId');
        die();
        var_dump($filieres);


        return $tableau;
    }

    public function distainctTable($tableau, $colonne)
    {  //11798
        foreach ($tableau as $key => $value) {
            $tab[$value[$colonne]] = $value;
        }
        foreach ($tab as $key => $value) {
            var_dump($key);
        }
        die();
        var_dump($tableau);

        die();
        return $tableau;
    }
}