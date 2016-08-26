<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PdfModeles
 *
 * @ORM\Table(name="pdf_modeles", indexes={@ORM\Index(name="id_pdf_type", columns={"id_pdf_type"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PdfModeles
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_modele", type="string", length=64, nullable=false)
     */
    private $libModele;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_modele", type="text", length=16777215, nullable=false)
     */
    private $descModele;

    /**
     * @var string
     *
     * @ORM\Column(name="code_pdf_modele", type="string", length=32, nullable=false)
     */
    private $codePdfModele;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pdf_modele", type="smallint")
     * @ORM\Id
     */
    private $idPdfModele;

    /**
     * @var \SS\FMBBundle\Entity\PdfTypes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\PdfTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pdf_type", referencedColumnName="id_pdf_type")
     * })
     */
    private $idPdfType;


    /**
     * Set libModele
     *
     * @param string $libModele
     * @return PdfModeles
     */
    public function setLibModele($libModele)
    {
        $this->libModele = $libModele;

        return $this;
    }

    /**
     * Get libModele
     *
     * @return string
     */
    public function getLibModele()
    {
        return $this->libModele;
    }

    /**
     * Set descModele
     *
     * @param string $descModele
     * @return PdfModeles
     */
    public function setDescModele($descModele)
    {
        $this->descModele = $descModele;

        return $this;
    }

    /**
     * Get descModele
     *
     * @return string
     */
    public function getDescModele()
    {
        return $this->descModele;
    }

    /**
     * Set codePdfModele
     *
     * @param string $codePdfModele
     * @return PdfModeles
     */
    public function setCodePdfModele($codePdfModele)
    {
        $this->codePdfModele = $codePdfModele;

        return $this;
    }

    /**
     * Get codePdfModele
     *
     * @return string
     */
    public function getCodePdfModele()
    {
        return $this->codePdfModele;
    }

    /**
     * Get idPdfModele
     *
     * @return integer
     */
    public function getIdPdfModele()
    {
        return $this->idPdfModele;
    }

    /**
     * Set idPdfType
     *
     * @param \SS\FMBBundle\Entity\PdfTypes $idPdfType
     * @return PdfModeles
     */
    public function setIdPdfType(\SS\FMBBundle\Entity\PdfTypes $idPdfType = null)
    {
        $this->idPdfType = $idPdfType;

        return $this;
    }

    /**
     * Get idPdfType
     *
     * @return \SS\FMBBundle\Entity\PdfTypes
     */
    public function getIdPdfType()
    {
        return $this->idPdfType;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateIdPdfModele()
    {
        $this->idPdfModele = uniqid();
    }

    /**
     * Set idPdfModele
     *
     * @param integer $idPdfModele
     * @return PdfModeles
     */
    public function setIdPdfModele($idPdfModele)
    {
        $this->idPdfModele = $idPdfModele;

        return $this;
    }
}
