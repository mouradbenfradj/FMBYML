<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocsLines
 *
 * @ORM\Table(name="docs_lines", indexes={@ORM\Index(name="ref_doc", columns={"ref_doc"}), @ORM\Index(name="ref_article", columns={"ref_article"}), @ORM\Index(name="ref_doc_line_parent", columns={"ref_doc_line_parent"})})
 * @ORM\Entity
 */
class DocsLines
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc", type="string", length=32, nullable=false)
     */
    private $refDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string", length=32, nullable=true)
     */
    private $refArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_article", type="string", length=250, nullable=false)
     */
    private $libArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_article", type="text", length=16777215, nullable=false)
     */
    private $descArticle;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float", precision=10, scale=0, nullable=false)
     */
    private $qte;

    /**
     * @var float
     *
     * @ORM\Column(name="pu_ht", type="float", precision=10, scale=0, nullable=false)
     */
    private $puHt;

    /**
     * @var float
     *
     * @ORM\Column(name="remise", type="float", precision=10, scale=0, nullable=false)
     */
    private $remise;

    /**
     * @var float
     *
     * @ORM\Column(name="tva", type="float", precision=10, scale=0, nullable=false)
     */
    private $tva;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="smallint", nullable=false)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc_line_parent", type="string", length=32, nullable=true)
     */
    private $refDocLineParent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc_line", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refDocLine;



    /**
     * Set refDoc
     *
     * @param string $refDoc
     * @return DocsLines
     */
    public function setRefDoc($refDoc)
    {
        $this->refDoc = $refDoc;

        return $this;
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
     * Set refArticle
     *
     * @param string $refArticle
     * @return DocsLines
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return string 
     */
    public function getRefArticle()
    {
        return $this->refArticle;
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
     * Get libArticle
     *
     * @return string 
     */
    public function getLibArticle()
    {
        return $this->libArticle;
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
     * Get descArticle
     *
     * @return string 
     */
    public function getDescArticle()
    {
        return $this->descArticle;
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
     * Get qte
     *
     * @return float 
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set puHt
     *
     * @param float $puHt
     * @return DocsLines
     */
    public function setPuHt($puHt)
    {
        $this->puHt = $puHt;

        return $this;
    }

    /**
     * Get puHt
     *
     * @return float 
     */
    public function getPuHt()
    {
        return $this->puHt;
    }

    /**
     * Set remise
     *
     * @param float $remise
     * @return DocsLines
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return float 
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return DocsLines
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return DocsLines
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set refDocLineParent
     *
     * @param string $refDocLineParent
     * @return DocsLines
     */
    public function setRefDocLineParent($refDocLineParent)
    {
        $this->refDocLineParent = $refDocLineParent;

        return $this;
    }

    /**
     * Get refDocLineParent
     *
     * @return string 
     */
    public function getRefDocLineParent()
    {
        return $this->refDocLineParent;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return DocsLines
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
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
}
