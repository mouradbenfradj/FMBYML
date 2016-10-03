<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticles
 *
 * @ORM\Table(name="stocks_articles", indexes={@ORM\Index(name="id_stock", columns={"id_stock"}), @ORM\Index(name="ref_article", columns={"ref_article"})})
 * @ORM\Entity
 */
class StocksArticles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="smallint", nullable=false)
     */
    private $idStock;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string", length=32, nullable=false)
     */
    private $refArticle;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_stock_article", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refStockArticle;



    /**
     * Set idStock
     *
     * @param integer $idStock
     * @return StocksArticles
     */
    public function setIdStock($idStock)
    {
        $this->idStock = $idStock;

        return $this;
    }

    /**
     * Get idStock
     *
     * @return integer 
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Set refArticle
     *
     * @param string $refArticle
     * @return StocksArticles
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return string 
     */
    public function getRefArticle()
    {
        return $this->refArticle;
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
     * Get qte
     *
     * @return float 
     */
    public function getQte()
    {
        return $this->qte;
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
}
