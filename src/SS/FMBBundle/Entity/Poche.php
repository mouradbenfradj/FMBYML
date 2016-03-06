<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Entity\PocheRepository")
 */
class Poche
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
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="emplacement", type="integer")
     */
    private $emplacement;


    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Lanterne", inversedBy="children")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lanterne;

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
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Poche
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return integer
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set emplacement
     *
     * @param integer $emplacement
     * @return Poche
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;

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
     * Set lanterne
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanterne
     * @return Poche
     */
    public function setLanterne(\SS\FMBBundle\Entity\Lanterne $lanterne)
    {
        $this->lanterne = $lanterne;

        return $this;
    }
}
