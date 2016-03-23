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
     * @ORM\OneToOne(targetEntity="SS\FMBBundle\Entity\Corde")
     */
    private $corde;
    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Flotteur", inversedBy="emplacements",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $flotteur;

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
}
