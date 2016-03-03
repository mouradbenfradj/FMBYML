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
     * @var string
     *
     * @ORM\Column(name="quantiter", type="decimal")
     */
    private $quantiter;

    /**
     * @var integer
     *
     * @ORM\Column(name="duplication", type="integer")
     */
    private $duplication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDajout", type="date")
     */
    private $dateDajout;


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
     * Get duplication
     *
     * @return integer
     */
    public function getDuplication()
    {
        return $this->duplication;
    }

    /**
     * Set duplication
     *
     * @param integer $duplication
     * @return Stockage
     */
    public function setDuplication($duplication)
    {
        $this->duplication = $duplication;

        return $this;
    }

    /**
     * Get dateDajout
     *
     * @return \DateTime
     */
    public function getDateDajout()
    {
        return $this->dateDajout;
    }

    /**
     * Set dateDajout
     *
     * @param \DateTime $dateDajout
     * @return Stockage
     */
    public function setDateDajout($dateDajout)
    {
        $this->dateDajout = $dateDajout;

        return $this;
    }
}
