<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stocks
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Stocks
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idStock;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_stock", type="string", length=250)
     */
    private $libStock;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_stock", type="string", length=250)
     */
    private $abrevStock;

    /**
     * @ORM\ManyToOne(targetEntity="Parc")
     * @ORM\JoinColumn(name="ref_adr_stock", nullable=FALSE)
     */
    private $refAdrStock;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;
    /**
     * @ORM\OneToMany(targetEntity="DocBlf", mappedBy="idStock")
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
     * Get idStock
     *
     * @return integer
     */
    public function getIdStock()
    {
        return $this->idStock;
    }

    /**
     * Get libStock
     *
     * @return string
     */
    public function getLibStock()
    {
        return $this->libStock;
    }

    /**
     * Set libStock
     *
     * @param string $libStock
     * @return Stocks
     */
    public function setLibStock($libStock)
    {
        $this->libStock = $libStock;

        return $this;
    }

    /**
     * Get abrevStock
     *
     * @return string
     */
    public function getAbrevStock()
    {
        return $this->abrevStock;
    }

    /**
     * Set abrevStock
     *
     * @param string $abrevStock
     * @return Stocks
     */
    public function setAbrevStock($abrevStock)
    {
        $this->abrevStock = $abrevStock;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Stocks
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Add docBlfs
     *
     * @param \SS\FMBBundle\Entity\DocBlf $docBlfs
     * @return Stocks
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
     * Get refAdrStock
     *
     * @return \SS\FMBBundle\Entity\Parc
     */
    public function getRefAdrStock()
    {
        return $this->refAdrStock;
    }

    /**
     * Set refAdrStock
     *
     * @param \SS\FMBBundle\Entity\Parc $refAdrStock
     * @return Stocks
     */
    public function setRefAdrStock(\SS\FMBBundle\Entity\Parc $refAdrStock)
    {
        $this->refAdrStock = $refAdrStock;

        return $this;
    }
}
