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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lot", type="string", length=255,unique=true)
     */
    private $lot;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\BonReception", mappedBy="nLot",cascade={"persist"})
     */
    private $bonReceptions;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
