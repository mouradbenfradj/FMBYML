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
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;
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
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Emplacement
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

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
}
