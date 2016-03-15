<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Segment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\SegmentRepository")
 */
class Segment
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
     * @ORM\Column(name="nomSegment", type="string", length=255)
     */
    private $nomSegment;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Filiere", inversedBy="segments",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\SSegment", mappedBy="segment")
     */
    private $ssegments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ssegments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get nomSegment
     *
     * @return string
     */
    public function getNomSegment()
    {
        return $this->nomSegment;
    }

    /**
     * Set nomSegment
     *
     * @param string $nomSegment
     * @return Segment
     */
    public function setNomSegment($nomSegment)
    {
        $this->nomSegment = $nomSegment;

        return $this;
    }


    /**
     * Add ssegments
     *
     * @param \SS\FMBBundle\Entity\SSegment $ssegments
     * @return Segment
     */
    public function addSsegment(\SS\FMBBundle\Entity\SSegment $ssegments)
    {
        $this->ssegments[] = $ssegments;
        $ssegments->setSegment($this);

        return $this;
    }

    /**
     * Remove ssegments
     *
     * @param \SS\FMBBundle\Entity\SSegment $ssegments
     */
    public function removeSsegment(\SS\FMBBundle\Entity\SSegment $ssegments)
    {
        $this->ssegments->removeElement($ssegments);
    }

    /**
     * Get ssegments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSsegments()
    {
        return $this->ssegments;
    }

    /**
     * Get filiere
     *
     * @return \SS\FMBBundle\Entity\Filiere
     */
    public function getFiliere()
    {
        return $this->filiere;
    }

    /**
     * Set filiere
     *
     * @param \SS\FMBBundle\Entity\Filiere $filiere
     * @return Segment
     */
    public function setFiliere(\SS\FMBBundle\Entity\Filiere $filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }
}
