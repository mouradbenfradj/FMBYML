<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corde
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\CordeRepository")
 */
class Corde
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
     * @var integer
     *
     * @ORM\Column(name="quantiter", type="integer")
     */
    private $quantiter;
    /**
     * @var boolean
     *
     * @ORM\Column(name="pret", type="boolean")
     */
    private $pret;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Emplacement", mappedBy="corde")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emplacement;

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
     * @return Corde
     */
    public function setQuantiter($quantiter)
    {
        $this->quantiter = $quantiter;

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
     * Set emplacement
     *
     * @param \SS\FMBBundle\Entity\Emplacement $emplacement
     * @return Corde
     */
    public function setEmplacement(\SS\FMBBundle\Entity\Emplacement $emplacement = null)
    {
        $this->emplacement = $emplacement;

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
     * @return Corde
     */
    public function setArticle(\SS\FMBBundle\Entity\Articles $article = null)
    {
        $this->article = $article;

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
     * @return Corde
     */
    public function setPret($pret)
    {
        $this->pret = $pret;

        return $this;
    }

    /**
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     * @return Corde
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
