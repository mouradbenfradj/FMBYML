<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string", length=32)
     * @ORM\Id
     */
    private $refArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_article", type="string", length=250)
     */
    private $libArticle;
    /**
     * @ORM\ManyToOne(targetEntity="Lot", cascade={"persist"})
     * @ORM\JoinColumn(name="lot", referencedColumnName="lot",nullable=false)
     */
    private $lot;

    public function __toString()
    {
        return $this->getLot()." ".$this->getLibArticle();
    }

    /**
     * Get lot
     *
     * @return \SS\FMBBundle\Entity\Lot
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set lot
     *
     * @param \SS\FMBBundle\Entity\Lot $lot
     * @return Articles
     */
    public function setLot(\SS\FMBBundle\Entity\Lot $lot)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get libArticle
     *
     * @return string
     */
    public function getLibArticle()
    {
        return $this->libArticle;
    }

    /**
     * Set libArticle
     *
     * @param string $libArticle
     * @return Articles
     */
    public function setLibArticle($libArticle)
    {
        $this->libArticle = $libArticle;

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
     * Set refArticle
     *
     * @param string $refArticle
     * @return Articles
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }
}
