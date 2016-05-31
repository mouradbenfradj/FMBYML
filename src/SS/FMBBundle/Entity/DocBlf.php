<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocBlf
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DocBlf
{

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Documents", inversedBy="docBlfs")
     * @ORM\JoinColumn(name="ref_doc", referencedColumnName="ref_doc")
     * @ORM\Id
     */
    private $refDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc_externe", type="string", length=32)
     */
    private $refDocExterne;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Stocks", inversedBy="docBlfs")
     * @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock")
     */
    private $idStock;

    /**
     * Get refDocExterne
     *
     * @return string
     */
    public function getRefDocExterne()
    {
        return $this->refDocExterne;
    }

    /**
     * Set refDocExterne
     *
     * @param string $refDocExterne
     * @return DocBlf
     */
    public function setRefDocExterne($refDocExterne)
    {
        $this->refDocExterne = $refDocExterne;

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
     * @return DocBlf
     */
    public function setRefDoc(\SS\FMBBundle\Entity\Documents $refDoc)
    {
        $this->refDoc = $refDoc;

        return $this;
    }

    /**
     * Get idStock
     *
     * @return \SS\FMBBundle\Entity\Stocks
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Set idStock
     *
     * @param \SS\FMBBundle\Entity\Stocks $idStock
     * @return DocBlf
     */
    public function setIdStock(\SS\FMBBundle\Entity\Stocks $idStock = null)
    {
        $this->idStock = $idStock;

        return $this;
    }
}
