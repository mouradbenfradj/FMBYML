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
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\TypeDocuments")
     * @ORM\JoinColumn(name="id_type_doc", referencedColumnName="id",nullable=false)
     */
    private $idTypeDoc;
    /**
     * @ORM\OneToMany(targetEntity="DocBlf", mappedBy="refDoc")
     */
    private $docBlfs;
    /**
     * @ORM\OneToMany(targetEntity="DocsLines", mappedBy="refDoc",cascade={"persist"})
     */
    private $docsLines;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->docBlfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->docsLines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idTypeDoc
     *
     * @return \SS\FMBBundle\Entity\TypeDocuments
     */
    public function getIdTypeDoc()
    {
        return $this->idTypeDoc;
    }

    /**
     * Set idTypeDoc
     *
     * @param \SS\FMBBundle\Entity\TypeDocuments $idTypeDoc
     * @return Documents
     */
    public function setIdTypeDoc(\SS\FMBBundle\Entity\TypeDocuments $idTypeDoc)
    {
        $this->idTypeDoc = $idTypeDoc;

        return $this;
    }

    /**
     * Get docsLines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocsLines()
    {
        return $this->docsLines;
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

    /**
     * Add docsLines
     *
     * @param \SS\FMBBundle\Entity\DocsLines $docsLines
     * @return Documents
     */
    public function addDocsLine(\SS\FMBBundle\Entity\DocsLines $docsLines)
    {
        $this->docsLines[] = $docsLines;
        $docsLines->setRefDoc($this);

        return $this;
    }

    /**
     * Remove docsLines
     *
     * @param \SS\FMBBundle\Entity\DocsLines $docsLines
     */
    public function removeDocsLine(\SS\FMBBundle\Entity\DocsLines $docsLines)
    {
        $this->docsLines->removeElement($docsLines);
    }
}
