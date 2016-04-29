<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="nomArticle", type="string", length=255,unique=true)
     */
    private $nomArticle;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\BonReception", mappedBy="article",cascade={"persist"})
     */
    private $bonReceptions;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Stockage", mappedBy="article",cascade={"persist"})
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
        return $this->getNomArticle();
    }

    /**
     * Get nomArticle
     *
     * @return string
     */
    public function getNomArticle()
    {
        return $this->nomArticle;
    }

    /**
     * Set nomArticle
     *
     * @param string $nomArticle
     * @return Article
     */
    public function setNomArticle($nomArticle)
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    /**
     * Add bonReceptions
     *
     * @param \SS\FMBBundle\Entity\BonReception $bonReceptions
     * @return Article
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
     * @return Article
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
