<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\FiliereRepository")
 */
class Filiere
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
     * @var string
     *
     * @ORM\Column(name="nomFiliere", type="string", length=255)
     */
    private $nomFiliere;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="filieres",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Segment", mappedBy="filiere",cascade={"persist","remove"})
     */
    private $segments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->segments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get nomFiliere
     *
     * @return string
     */
    public function getNomFiliere()
    {
        return $this->nomFiliere;
    }

    /**
     * Set nomFiliere
     *
     * @param string $nomFiliere
     * @return Filiere
     */
    public function setNomFiliere($nomFiliere)
    {
        $this->nomFiliere = $nomFiliere;

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
     * @return Filiere
     */
    public function setParc(\SS\FMBBundle\Entity\Parc $parc)
    {
        $this->parc = $parc;

        return $this;
    }


    /**
     * Add segments
     *
     * @param \SS\FMBBundle\Entity\Segment $segment
     * @return Filiere
     */
    public function addSegment(\SS\FMBBundle\Entity\Segment $segment)
    {
        $this->segments[] = $segment;
        $segment->setFiliere($this);
        return $this;
    }

    /**
     * Remove segments
     *
     * @param \SS\FMBBundle\Entity\Segment $segments
     */
    public function removeSegment(\SS\FMBBundle\Entity\Segment $segments)
    {
        $this->segments->removeElement($segments);
    }

    /**
     * Get segments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSegments()
    {
        return $this->segments;
    }
}
