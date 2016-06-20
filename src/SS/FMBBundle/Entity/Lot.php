<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lot
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Lot
{

    /**
     * @var string
     *
     * @ORM\Column(name="lot", type="string", length=255)
     * @ORM\Id
     */
    private $lot;

    public function __toString()
    {
        return $this->getLot();
    }

    /**
     * Get lot
     *
     * @return string
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set lot
     *
     * @param string $lot
     * @return Lot
     */
    public function setLot($lot)
    {
        $this->lot = $lot;

        return $this;
    }
}
