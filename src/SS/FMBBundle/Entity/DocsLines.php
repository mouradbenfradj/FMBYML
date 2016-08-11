<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocsLines
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class DocsLines
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc_line", type="string", length=32)
     * @ORM\Id
     */
    private $refDocLine;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Documents",cascade={"persist"})
     * @ORM\JoinColumn(name="ref_doc", referencedColumnName="ref_doc",nullable=false)
     */
    private $refDoc;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Articles")
     * @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article",nullable=false)
     */
    private $refArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="libArticle", type="string", length=250, nullable=true)
     */
    private $libArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="descArticle", type="text", nullable=true)
     */
    private $descArticle;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\DocsLines")
     * @ORM\JoinColumn(name="ref_doc_line_parent", referencedColumnName="ref_doc_line")
     */
    private $refDocLineParent;

    /**
     * @ORM\OneToMany(targetEntity="DocsLines", mappedBy="ref_doc_line_parent")
     */
    private $children;

    /**
     * @ORM\PrePersist
     */
    public function generateRefDocLine()
    {
        $this->refDocLine = uniqid();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get libArticle
     *
     * @return string
     */
    public function getLibArticle()
    {
        return $this->libArticle;
    }

    /**
     * Set libArticle
     *
     * @param string $libArticle
     * @return DocsLines
     */
    public function setLibArticle($libArticle)
    {
        $this->libArticle = $libArticle;

        return $this;
    }

    /**
     * Get descArticle
     *
     * @return string
     */
    public function getDescArticle()
    {
        return $this->descArticle;
    }

    /**
     * Set descArticle
     *
     * @param string $descArticle
     * @return DocsLines
     */
    public function setDescArticle($descArticle)
    {
        $this->descArticle = $descArticle;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set qte
     *
     * @param float $qte
     * @return DocsLines
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get refDoc
     *
     * @return \SS\FMBBundle\Entity\Documents
     */
    public function getRefDoc()
    {
        return $this->refDoc;
    }

    /**
     * Set refDoc
     *
     * @param \SS\FMBBundle\Entity\Documents $refDoc
     * @return DocsLines
     */
    public function setRefDoc(\SS\FMBBundle\Entity\Documents $refDoc)
    {
        $this->refDoc = $refDoc;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return \SS\FMBBundle\Entity\Articles
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set refArticle
     *
     * @param \SS\FMBBundle\Entity\Articles $refArticle
     * @return DocsLines
     */
    public function setRefArticle(\SS\FMBBundle\Entity\Articles $refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }

    /**
     * Get refDocLineParent
     *
     * @return \SS\FMBBundle\Entity\DocsLines
     */
    public function getRefDocLineParent()
    {
        return $this->refDocLineParent;
    }

    /**
     * Set refDocLineParent
     *
     * @param \SS\FMBBundle\Entity\DocsLines $refDocLineParent
     * @return DocsLines
     */
    public function setRefDocLineParent(\SS\FMBBundle\Entity\DocsLines $refDocLineParent = null)
    {
        $this->refDocLineParent = $refDocLineParent;

        return $this;
    }

    /**
     * Add children
     *
     * @param \SS\FMBBundle\Entity\DocsLines $children
     * @return DocsLines
     */
    public function addChild(\SS\FMBBundle\Entity\DocsLines $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \SS\FMBBundle\Entity\DocsLines $children
     */
    public function removeChild(\SS\FMBBundle\Entity\DocsLines $children)
    {
        $this->children->removeElement($children);
    }

    public function __toString()
    {
        return $this->getRefDocLine();
    }

    /**
     * Get refDocLine
     *
     * @return string
     */
    public function getRefDocLine()
    {
        return $this->refDocLine;
    }

    /**
     * Set refDocLine
     *
     * @param string $refDocLine
     * @return DocsLines
     */
    public function setRefDocLine($refDocLine)
    {
        $this->refDocLine = $refDocLine;

        return $this;
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
