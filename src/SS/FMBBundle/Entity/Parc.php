<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parc
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\ParcRepository")
 */
class Parc
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
     * @ORM\Column(name="nomParc", type="string", length=255, unique=true)
     */
    private $nomParc;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Filiere", mappedBy="parc" ,cascade={"remove"})
     */
    private $filieres;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\StocksLanternes", mappedBy="parc",cascade={"remove"})
     */
    private $stockslanternes;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Stocks", mappedBy="refAdrStock",cascade={"remove"})
     */
    private $stock;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lanternes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->st = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     * @return Parc
     */
    public function addFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres[] = $filieres;
        $filieres->setParc($this);
        return $this;
    }
    public function __toString()
    {
        return $this->getNomParc();
    }

    /**
     * Set nomParc
     *
     * @param string $nomParc
     * @return Parc
     */
    public function setNomParc($nomParc)
    {
        $this->nomParc = $nomParc;

        return $this;
    }

    /**
     * Get nomParc
     *
     * @return string 
     */
    public function getNomParc()
    {
        return $this->nomParc;
    }

    /**
     * Remove filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     */
    public function removeFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres->removeElement($filieres);
    }

    /**
     * Get filieres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieres()
    {
        return $this->filieres;
    }

    /**
     * Add stockslanternes
     *
     * @param \SS\FMBBundle\Entity\StocksLanternes $stockslanternes
     * @return Parc
     */
    public function addStockslanterne(\SS\FMBBundle\Entity\StocksLanternes $stockslanternes)
    {
        $this->stockslanternes[] = $stockslanternes;

        return $this;
    }

    /**
     * Remove stockslanternes
     *
     * @param \SS\FMBBundle\Entity\StocksLanternes $stockslanternes
     */
    public function removeStockslanterne(\SS\FMBBundle\Entity\StocksLanternes $stockslanternes)
    {
        $this->stockslanternes->removeElement($stockslanternes);
    }

    /**
     * Get stockslanternes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStockslanternes()
    {
        return $this->stockslanternes;
    }

    /**
     * Add stock
     *
     * @param \SS\FMBBundle\Entity\Stocks $stock
     * @return Parc
     */
    public function addStock(\SS\FMBBundle\Entity\Stocks $stock)
    {
        $this->stock[] = $stock;

        return $this;
    }

    /**
     * Remove stock
     *
     * @param \SS\FMBBundle\Entity\Stocks $stock
     */
    public function removeStock(\SS\FMBBundle\Entity\Stocks $stock)
    {
        $this->stock->removeElement($stock);
    }

    /**
     * Get stock
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStock()
    {
        return $this->stock;
    }
}
