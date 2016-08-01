<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\EmplacementRepository")
 */
class Emplacement
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
     * @ORM\Column(name="place", type="integer")
     */
    private $place;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Corde", inversedBy="emplacement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $corde;
    /**
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Lanterne", inversedBy="emplacement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lanterne;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Flotteur", inversedBy="emplacements",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $flotteur;
    /**
     *
     * @ORM\Column(name="date_remplissage", type="date",nullable=true)
     */
    private $dateDeRemplissage;

    /**
     * Get place
     *
     * @return integer
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set place
     *
     * @param integer $place
     * @return Emplacement
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    public function __toString()
    {
        return $this->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return "".$this->id;
    }

    /**
     * Get flotteur
     *
     * @return \SS\FMBBundle\Entity\Flotteur
     */
    public function getFlotteur()
    {
        return $this->flotteur;
    }

    /**
     * Set flotteur
     *
     * @param \SS\FMBBundle\Entity\Flotteur $flotteur
     * @return Emplacement
     */
    public function setFlotteur(\SS\FMBBundle\Entity\Flotteur $flotteur)
    {
        $this->flotteur = $flotteur;

        return $this;
    }

    /**
     * Get corde
     *
     * @return \SS\FMBBundle\Entity\Corde
     */
    public function getCorde()
    {
        return $this->corde;
    }

    /**
     * Set corde
     *
     * @param \SS\FMBBundle\Entity\Corde $corde
     * @return Emplacement
     */
    public function setCorde(\SS\FMBBundle\Entity\Corde $corde = null)
    {
        $this->corde = $corde;

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
     * @return Emplacement
     */
    public function setLanterne(\SS\FMBBundle\Entity\Lanterne $lanterne = null)
    {
        $this->lanterne = $lanterne;

        return $this;
    }

    /**
     * Get dateDeRemplissage
     *
     * @return \DateTime
     */
    public function getDateDeRemplissage()
    {
        return $this->dateDeRemplissage;
    }

    /**
     * Set dateDeRemplissage
     *
     * @param \DateTime $dateDeRemplissage
     * @return Emplacement
     */
    public function setDateDeRemplissage($dateDeRemplissage)
    {
        $this->dateDeRemplissage = $dateDeRemplissage;

        return $this;
    }
}
