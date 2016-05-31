<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ducuments
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Documents
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc", type="string", length=32)
     * @ORM\Id
     */
    private $refDoc;

    /**
     * @ORM\OneToMany(targetEntity="DocBlf", mappedBy="refDoc")
     */
    private $docBlfs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->docBlfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get refDoc
     *
     * @return string
     */
    public function getRefDoc()
    {
        return $this->refDoc;
    }

    /**
     * Set refDoc
     *
     * @param string $refDoc
     * @return Documents
     */
    public function setRefDoc($refDoc)
    {
        $this->refDoc = $refDoc;

        return $this;
    }

    /**
     * Add docBlfs
     *
     * @param \SS\FMBBundle\Entity\DocBlf $docBlfs
     * @return Documents
     */
    public function addDocBlf(\SS\FMBBundle\Entity\DocBlf $docBlfs)
    {
        $this->docBlfs[] = $docBlfs;

        return $this;
    }

    /**
     * Remove docBlfs
     *
     * @param \SS\FMBBundle\Entity\DocBlf $docBlfs
     */
    public function removeDocBlf(\SS\FMBBundle\Entity\DocBlf $docBlfs)
    {
        $this->docBlfs->removeElement($docBlfs);
    }

    /**
     * Get docBlfs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocBlfs()
    {
        return $this->docBlfs;
    }
}
