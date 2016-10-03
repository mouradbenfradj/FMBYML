<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stocks
 *
 * @ORM\Table(name="stocks", indexes={@ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="ref_adr_stock", columns={"ref_adr_stock"})})
 * @ORM\Entity
 */
class Stocks
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_stock", type="string", length=32, nullable=false)
     */
    private $libStock;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_stock", type="string", length=32, nullable=false)
     */
    private $abrevStock;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_adr_stock", type="string", length=32, nullable=true)
     */
    private $refAdrStock;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStock;



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
     * Get libStock
     *
     * @return string 
     */
    public function getLibStock()
    {
        return $this->libStock;
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
     * Get abrevStock
     *
     * @return string 
     */
    public function getAbrevStock()
    {
        return $this->abrevStock;
    }

    /**
     * Set refAdrStock
     *
     * @param string $refAdrStock
     * @return Stocks
     */
    public function setRefAdrStock($refAdrStock)
    {
        $this->refAdrStock = $refAdrStock;

        return $this;
    }

    /**
     * Get refAdrStock
     *
     * @return string 
     */
    public function getRefAdrStock()
    {
        return $this->refAdrStock;
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
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
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
}
