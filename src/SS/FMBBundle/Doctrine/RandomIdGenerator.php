<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 28/05/2016
 * Time: 18:46
 */

namespace SS\FMBBundle\Doctrine;

use Doctrine\ORM\Id\AbstractIdGenerator;


class RandomIdGenerator extends AbstractIdGenerator
{
    public
    function generate(
        \Doctrine\ORM\EntityManager $em,
        $entity
    ) {
        $entity_name = $em->getClassMetadata(get_class($entity))->getName();

        while (true) {
            $id = mt_rand(100000, 999999);
            $item = $em->find($entity_name, $id);

            if (!$item) {
                return $id;
            }
        }

        throw new \Exception('RandomIdGenerator worked hard, but could not generate unique ID :(');
    }
}