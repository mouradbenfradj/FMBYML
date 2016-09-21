<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corde
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\CordeRepository")
 */
class Corde
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
     * @var integer
     * @ORM\Column(name="nbrtotaleEnStock", type="integer")
     */
    private $nbrTotaleEnStock;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\StocksCordes", mappedBy="corde",cascade={"persist","remove"})
     */
    private $stockscordes;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Magasins", fetch="EAGER")
     * @ORM\JoinColumn(name="magasin", referencedColumnName="id_magasin",nullable=false)
     */
    private $parc;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stockscordes = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set nbrTotaleEnStock
     *
     * @param integer $nbrTotaleEnStock
     * @return Corde
     */
    public function setNbrTotaleEnStock($nbrTotaleEnStock)
    {
        $this->nbrTotaleEnStock = $nbrTotaleEnStock;

        return $this;
    }

    /**
     * Get nbrTotaleEnStock
     *
     * @return integer 
     */
    public function getNbrTotaleEnStock()
    {
        return $this->nbrTotaleEnStock;
    }

    /**
     * Add stockscordes
     *
     * @param \SS\FMBBundle\Entity\StocksCordes $stockscordes
     * @return Corde
     */
    public function addStockscorde(\SS\FMBBundle\Entity\StocksCordes $stockscordes)
    {
        $this->stockscordes[] = $stockscordes;

        return $this;
    }

    /**
     * Remove stockscordes
     *
     * @param \SS\FMBBundle\Entity\StocksCordes $stockscordes
     */
    public function removeStockscorde(\SS\FMBBundle\Entity\StocksCordes $stockscordes)
    {
        $this->stockscordes->removeElement($stockscordes);
    }

    /**
     * Get stockscordes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStockscordes()
    {
        return $this->stockscordes;
    }

    /**
     * Set parc
     *
     * @param \SS\FMBBundle\Entity\Magasins $parc
     * @return Corde
     */
    public function setParc(\SS\FMBBundle\Entity\Magasins $parc)
    {
        $this->parc = $parc;

        return $this;
    }

    /**
     * Get parc
     *
     * @return \SS\FMBBundle\Entity\Magasins 
     */
    public function getParc()
    {
        return $this->parc;
    }
}
