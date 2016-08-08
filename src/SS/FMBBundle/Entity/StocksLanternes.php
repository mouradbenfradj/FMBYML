<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StocksLanternes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\StocksLanternesRepository")
 */
class StocksLanternes
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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Lanterne", inversedBy="stockslanternes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,  referencedColumnName="nomLanterne")
     */
    private $lanterne;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Poche", mappedBy="stocklanterne",cascade={"persist","remove"})
     */
    private $poches;

    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Emplacement", mappedBy="lanterne")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emplacement;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="lanternes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pret", type="boolean")
     */
    private $pret;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Articles")
     * @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article")
     */
    private $article;
    /**
     *
     * @ORM\Column(name="dateDeCreation", type="date")
     */
    private $dateDeCreation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get lanterne
     *
     * @return \SS\FMBBundle\Entity\Lanterne
     */
    public function getLanterne()
    {
        return $this->lanterne;
    }

    /**
     * Set lanterne
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanterne
     * @return StocksLanternes
     */
    public function setLanterne(\SS\FMBBundle\Entity\Lanterne $lanterne)
    {
        $this->lanterne = $lanterne;

        return $this;
    }

    /**
     * Add poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     * @return StocksLanternes
     */
    public function addPoch(\SS\FMBBundle\Entity\Poche $poches)
    {
        $this->poches[] = $poches;
        $poches->setStocklanterne($this);

        return $this;
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
     * Remove poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     */
    public function removePoch(\SS\FMBBundle\Entity\Poche $poches)
    {
        $this->poches->removeElement($poches);
    }

    /**
     * Get poches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoches()
    {
        return $this->poches;
    }

    /**
     * Get emplacement
     *
     * @return \SS\FMBBundle\Entity\Emplacement
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set emplacement
     *
     * @param \SS\FMBBundle\Entity\Emplacement $emplacement
     * @return StocksLanternes
     */
    public function setEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacement = null)
    {
        $this->emplacement = $emplacement;

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
     * @return StocksLanternes
     */
    public function setParc(\SS\FMBBundle\Entity\Parc $parc)
    {
        $this->parc = $parc;

        return $this;
    }

    /**
     * Get pret
     *
     * @return boolean
     */
    public function getPret()
    {
        return $this->pret;
    }

    /**
     * Set pret
     *
     * @param boolean $pret
     * @return StocksLanternes
     */
    public function setPret($pret)
    {
        $this->pret = $pret;

        return $this;
    }

    /**
     * Get article
     *
     * @return \SS\FMBBundle\Entity\Articles
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set article
     *
     * @param \SS\FMBBundle\Entity\Articles $article
     * @return StocksLanternes
     */
    public function setArticle(\SS\FMBBundle\Entity\Articles $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     * @return StocksLanternes
     */
    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    /**
     * Get dateDeCreation
     *
     * @return \DateTime 
     */
    public function getDateDeCreation()
    {
        return $this->dateDeCreation;
    }
}
