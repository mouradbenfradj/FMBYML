<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticles
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class StocksArticles
{

    /**
     * @var string
     *
     * @ORM\Column(name="ref_stock_article", type="string", length=32)
     * @ORM\Id
     */
    private $refStockArticle;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Stocks")
     * @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock",nullable=false)
     */
    private $idStock;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Articles")
     * @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article",nullable=false)
     */
    private $refArticle;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;

    /**
     * @ORM\PrePersist
     */
    public function generateRefStockArticle()
    {
        $this->refStockArticle = uniqid();
    }
    /**
     * Get refStockArticle
     *
     * @return string
     */
    public function getRefStockArticle()
    {
        return $this->refStockArticle;
    }

    /**
     * Set refStockArticle
     *
     * @param string $refStockArticle
     * @return StocksArticles
     */
    public function setRefStockArticle($refStockArticle)
    {
        $this->refStockArticle = $refStockArticle;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set qte
     *
     * @param float $qte
     * @return StocksArticles
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get idStock
     *
     * @return \SS\FMBBundle\Entity\Stocks
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Set idStock
     *
     * @param \SS\FMBBundle\Entity\Stocks $idStock
     * @return StocksArticles
     */
    public function setIdStock(\SS\FMBBundle\Entity\Stocks $idStock)
    {
        $this->idStock = $idStock;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return \SS\FMBBundle\Entity\Articles
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set refArticle
     *
     * @param \SS\FMBBundle\Entity\Articles $refArticle
     * @return StocksArticles
     */
    public function setRefArticle(\SS\FMBBundle\Entity\Articles $refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }
}
