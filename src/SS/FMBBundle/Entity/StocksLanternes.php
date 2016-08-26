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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\DocsLines")
     * @ORM\JoinColumn(name="doc_line", referencedColumnName="ref_doc_line")
     */
    private $docLine;

    public function __toString()
    {
        return "" . $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get pret
     *
     * @return boolean 
     */
    public function getPret()
    {
        return $this->pret;
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
     * Get lanterne
     *
     * @return \SS\FMBBundle\Entity\Lanterne 
     */
    public function getLanterne()
    {
        return $this->lanterne;
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

        return $this;
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
     * Get emplacement
     *
     * @return \SS\FMBBundle\Entity\Emplacement 
     */
    public function getEmplacement()
    {
        return $this->emplacement;
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
     * Get article
     *
     * @return \SS\FMBBundle\Entity\Articles 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set docLine
     *
     * @param \SS\FMBBundle\Entity\DocsLines $docLine
     * @return StocksLanternes
     */
    public function setDocLine(\SS\FMBBundle\Entity\DocsLines $docLine = null)
    {
        $this->docLine = $docLine;

        return $this;
    }

    /**
     * Get docLine
     *
     * @return \SS\FMBBundle\Entity\DocsLines 
     */
    public function getDocLine()
    {
        return $this->docLine;
    }
}
