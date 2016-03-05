<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stockage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Entity\StockageRepository")
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
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=255)
     */
    private $article;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantiter", type="integer")
     */
    private $quantiter;


    /**
     * @var string
     *
     * @ORM\Column(name="nlot", type="string", length=255)
     */
    private $NLot;


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
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Stockage
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get quantiter
     *
     * @return string
     */
    public function getQuantiter()
    {
        return $this->quantiter;
    }

    /**
     * Set quantiter
     *
     * @param string $quantiter
     * @return Stockage
     */
    public function setQuantiter($quantiter)
    {
        $this->quantiter = $quantiter;

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
}
