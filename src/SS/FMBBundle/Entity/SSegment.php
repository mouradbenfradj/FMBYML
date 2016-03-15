<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SSegment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\SSegmentRepository")
 */
class SSegment
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
     * @ORM\Column(name="nomSSegment", type="string", length=255)
     */
    private $nomSSegment;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Segment", inversedBy="ssegments")
     */
    private $segment;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Corde", mappedBy="ssegment")
     */
    private $cordes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cordes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get nomSSegment
     *
     * @return string
     */
    public function getNomSSegment()
    {
        return $this->nomSSegment;
    }

    /**
     * Set nomSSegment
     *
     * @param string $nomSSegment
     * @return SSegment
     */
    public function setNomSSegment($nomSSegment)
    {
        $this->nomSSegment = $nomSSegment;

        return $this;
    }

    /**
     * Get segment
     *
     * @return \SS\FMBBundle\Entity\Segment
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * Set segment
     *
     * @param \SS\FMBBundle\Entity\Segment $segment
     * @return SSegment
     */
    public function setSegment(\SS\FMBBundle\Entity\Segment $segment = null)
    {
        $this->segment = $segment;

        return $this;
    }

    /**
     * Add cordes
     *
     * @param \SS\FMBBundle\Entity\Corde $cordes
     * @return SSegment
     */
    public function addCorde(\SS\FMBBundle\Entity\Corde $cordes)
    {
        $this->cordes[] = $cordes;
        $cordes->setSsegment($this);

        return $this;
    }

    /**
     * Remove cordes
     *
     * @param \SS\FMBBundle\Entity\Corde $cordes
     */
    public function removeCorde(\SS\FMBBundle\Entity\Corde $cordes)
    {
        $this->cordes->removeElement($cordes);
    }

    /**
     * Get cordes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCordes()
    {
        return $this->cordes;
    }
}
