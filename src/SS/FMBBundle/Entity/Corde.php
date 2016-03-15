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
     * @ORM\Column(name="placeCorde", type="integer")
     */
    private $placeCorde;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etatCorde", type="boolean")
     */
    private $etatCorde;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantiter", type="integer")
     */
    private $quantiter;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\SSegment", inversedBy="cordes")
     */
    private $ssegment;

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
     * Get etatCorde
     *
     * @return boolean
     */
    public function getEtatCorde()
    {
        return $this->etatCorde;
    }

    /**
     * Set etatCorde
     *
     * @param boolean $etatCorde
     * @return Corde
     */
    public function setEtatCorde($etatCorde)
    {
        $this->etatCorde = $etatCorde;

        return $this;
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
     * Get ssegment
     *
     * @return \SS\FMBBundle\Entity\SSegment
     */
    public function getSsegment()
    {
        return $this->ssegment;
    }

    /**
     * Set ssegment
     *
     * @param \SS\FMBBundle\Entity\SSegment $ssegment
     * @return Corde
     */
    public function setSsegment(\SS\FMBBundle\Entity\SSegment $ssegment = null)
    {
        $this->ssegment = $ssegment;

        return $this;
    }

    /**
     * Get placeCorde
     *
     * @return integer
     */
    public function getPlaceCorde()
    {
        return $this->placeCorde;
    }

    /**
     * Set placeCorde
     *
     * @param integer $placeCorde
     * @return Corde
     */
    public function setPlaceCorde($placeCorde)
    {
        $this->placeCorde = $placeCorde;

        return $this;
    }
}
