<?php

namespace SS\FMBBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * BonReception
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\BonReceptionRepository")
 */
class BonReception
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
     * @var integer
     *
     * @ORM\Column(name="duplication", type="integer")
     */
    private $duplication;

    /**
     * @var \DateTime $dateDeReception
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateDeReception;

    /**
     * @var string
     *
     * @ORM\Column(name="nLot", type="string", length=255)
     */
    private $nLot;


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
     * @return BonReception
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
     * @return BonReception
     */
    public function setDuplication($duplication)
    {
        $this->duplication = $duplication;

        return $this;
    }

    /**
     * Get nLot
     *
     * @return string
     */
    public function getNLot()
    {
        return $this->nLot;
    }

    /**
     * Set nLot
     *
     * @param string $nLot
     * @return BonReception
     */
    public function setNLot($nLot)
    {
        $this->nLot = $nLot;

        return $this;
    }

    /**
     * Get dateDeReception
     *
     * @return \DateTime
     */
    public function getDateDeReception()
    {
        return $this->dateDeReception;
    }

    /**
     * Set dateDeReception
     *
     * @param \DateTime $dateDeReception
     * @return BonReception
     */
    public function setDateDeReception($dateDeReception)
    {
        $this->dateDeReception = $dateDeReception;

        return $this;
    }
}
