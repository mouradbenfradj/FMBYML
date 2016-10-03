<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticlesSn
 *
 * @ORM\Table(name="stocks_articles_sn", indexes={@ORM\Index(name="numero_serie", columns={"numero_serie"}), @ORM\Index(name="ref_stock_article", columns={"ref_stock_article"})})
 * @ORM\Entity
 */
class StocksArticlesSn
{
    /**
     * @var float
     *
     * @ORM\Column(name="sn_qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $snQte;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_stock_article", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $refStockArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numeroSerie;



    /**
     * Set snQte
     *
     * @param float $snQte
     * @return StocksArticlesSn
     */
    public function setSnQte($snQte)
    {
        $this->snQte = $snQte;

        return $this;
    }

    /**
     * Get snQte
     *
     * @return float 
     */
    public function getSnQte()
    {
        return $this->snQte;
    }

    /**
     * Set refStockArticle
     *
     * @param string $refStockArticle
     * @return StocksArticlesSn
     */
    public function setRefStockArticle($refStockArticle)
    {
        $this->refStockArticle = $refStockArticle;

        return $this;
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
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return StocksArticlesSn
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    /**
     * Get numeroSerie
     *
     * @return string 
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }
}
