<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 08/08/2016
 * Time: 12:09
 */

namespace SS\FMBBundle\Implementation;


use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Interfaces\DefaultInterface;

class DefaultImpl implements DefaultInterface
{
    protected $em;
    public function __construct($entitymanager)
    {
        $this->em = $entitymanager;
    }

    public function generateurNumeroDeLotParDateDuJour()
    {
        if (!$this->em->getRepository('SSFMBBundle:Lot')->find(date("Ymd"))) {
            $lotId = new Lot();
            $lotId->setLot(date("Ymd"));
            $this->em->persist($lotId);
            $this->em->flush();
        }
    }
}