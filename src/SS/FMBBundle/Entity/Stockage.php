<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stockage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StockageRepository")
 */
class Stockage
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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Article", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantiter", type="integer")
     */
    private $quantiter;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="stocks",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;

    public function __construct()
    {
        $this->quantiter = 0;
        $this->nLot = "000000";
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
     * Get quantiter
     *
     * @return integer
     */
    public function getQuantiter()
    {
        return $this->quantiter;
    }

    /**
     * Set quantiter
     *
     * @param integer $quantiter
     * @return Stockage
     */
    public function setQuantiter($quantiter)
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    /**
     * Set NLot
     *
     * @param string $nLot
     * @return Stockage
     */
    public function setNLot($nLot)
    {
        $this->NLot = $nLot;

        return $this;
    }

    /**
     * Get NLot
     *
     * @return string
     */
    public function getNLot()
    {
        return $this->NLot;
    }

    /**
     * Get article
     *
     * @return \SS\FMBBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set article
     *
     * @param \SS\FMBBundle\Entity\Article $article
     * @return Stockage
     */
    public function setArticle(\SS\FMBBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get parc
     *
     * @return \SS\FMBBundle\Entity\Parc
     */
    public function getParc()
    {
        return $this->parc;
    }

    /**
     * Set parc
     *
     * @param \SS\FMBBundle\Entity\Parc $parc
     * @return Stockage
     */
    public function setParc(\SS\FMBBundle\Entity\Parc $parc)
    {
        $this->parc = $parc;

        return $this;
    }
}
