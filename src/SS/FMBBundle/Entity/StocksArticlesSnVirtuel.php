<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksArticlesSnVirtuel
 *
 * @ORM\Table(name="stocks_articles_sn_virtuel", indexes={@ORM\Index(name="numero_serie", columns={"numero_serie"}), @ORM\Index(name="ref_stock_article", columns={"ref_stock_article"})})
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StocksArticlesSnVirtuelRepository")
 */
class StocksArticlesSnVirtuel
{
    /**
     * @var float
     *
     * @ORM\Column(name="sn_qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $snQte;
    /**
     * @var float
     *
     * @ORM\Column(name="sn_qte_morte", type="float", precision=10, scale=0, nullable=true)
     */
    private $snQteMorte = 0;
    /**
     * @var float
     *
     * @ORM\Column(name="sn_qte_perdu", type="float", precision=10, scale=0, nullable=true)
     */
    private $snQtePerdu = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numeroSerie;

    /**
     * @var \SS\FMBBundle\Entity\StocksArticles
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\StocksArticles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_stock_article", referencedColumnName="ref_stock_article")
     * })
     */
    private $refStockArticle;

    public function __construct($numeroSerie, $snQte, StocksArticles $refStockArticle)
    {
        $this->numeroSerie = $numeroSerie;
        $this->snQte = $snQte;
        $this->refStockArticle = $refStockArticle;
        $this->setSnQteMorte(0);
        $this->setSnQtePerdu(0);
    }

    public function __toString()
    {
        return $this->numeroSerie;
    }



    /**
     * Set snQte
     *
     * @param float $snQte
     * @return StocksArticlesSnVirtuel
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
     * Set snQteMorte
     *
     * @param float $snQteMorte
     * @return StocksArticlesSnVirtuel
     */
    public function setSnQteMorte($snQteMorte)
    {
        $this->snQteMorte = $snQteMorte;

        return $this;
    }

    /**
     * Get snQteMorte
     *
     * @return float 
     */
    public function getSnQteMorte()
    {
        return $this->snQteMorte;
    }

    /**
     * Set snQtePerdu
     *
     * @param float $snQtePerdu
     * @return StocksArticlesSnVirtuel
     */
    public function setSnQtePerdu($snQtePerdu)
    {
        $this->snQtePerdu = $snQtePerdu;

        return $this;
    }

    /**
     * Get snQtePerdu
     *
     * @return float 
     */
    public function getSnQtePerdu()
    {
        return $this->snQtePerdu;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return StocksArticlesSnVirtuel
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

    /**
     * Set refStockArticle
     *
     * @param \SS\FMBBundle\Entity\StocksArticles $refStockArticle
     * @return StocksArticlesSnVirtuel
     */
    public function setRefStockArticle(\SS\FMBBundle\Entity\StocksArticles $refStockArticle)
    {
        $this->refStockArticle = $refStockArticle;

        return $this;
    }

    /**
     * Get refStockArticle
     *
     * @return \SS\FMBBundle\Entity\StocksArticles 
     */
    public function getRefStockArticle()
    {
        return $this->refStockArticle;
    }
}
