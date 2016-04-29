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
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Stockage", mappedBy="nLot",cascade={"persist"})
     */
    private $stocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bonReceptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

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

    /**
     * Add bonReceptions
     *
     * @param \SS\FMBBundle\Entity\BonReception $bonReceptions
     * @return Lot
     */
    public function addBonReception(\SS\FMBBundle\Entity\BonReception $bonReceptions)
    {
        $this->bonReceptions[] = $bonReceptions;

        return $this;
    }

    /**
     * Remove bonReceptions
     *
     * @param \SS\FMBBundle\Entity\BonReception $bonReceptions
     */
    public function removeBonReception(\SS\FMBBundle\Entity\BonReception $bonReceptions)
    {
        $this->bonReceptions->removeElement($bonReceptions);
    }

    /**
     * Get bonReceptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBonReceptions()
    {
        return $this->bonReceptions;
    }

    /**
     * Add stocks
     *
     * @param \SS\FMBBundle\Entity\Stockage $stocks
     * @return Lot
     */
    public function addStock(\SS\FMBBundle\Entity\Stockage $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \SS\FMBBundle\Entity\Stockage $stocks
     */
    public function removeStock(\SS\FMBBundle\Entity\Stockage $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStocks()
    {
        return $this->stocks;
    }
}
