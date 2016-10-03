<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasins
 *
 * @ORM\Table(name="magasins", indexes={@ORM\Index(name="id_stock", columns={"id_stock"}), @ORM\Index(name="id_tarif", columns={"id_tarif"}), @ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="id_mag_enseigne", columns={"id_mag_enseigne"})})
 * @ORM\Entity
 */
class Magasins
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_magasin", type="string", length=64, nullable=false)
     */
    private $libMagasin;

    /**
     * @var string
     *
     * @ORM\Column(name="abrev_magasin", type="string", length=32, nullable=false)
     */
    private $abrevMagasin;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_mag_enseigne", type="smallint", nullable=true)
     */
    private $idMagEnseigne;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="smallint", nullable=false)
     */
    private $idStock;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tarif", type="smallint", nullable=false)
     */
    private $idTarif;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_vente", type="string", nullable=false)
     */
    private $modeVente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_magasin", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMagasin;



    /**
     * Set libMagasin
     *
     * @param string $libMagasin
     * @return Magasins
     */
    public function setLibMagasin($libMagasin)
    {
        $this->libMagasin = $libMagasin;

        return $this;
    }

    /**
     * Get libMagasin
     *
     * @return string 
     */
    public function getLibMagasin()
    {
        return $this->libMagasin;
    }

    /**
     * Set abrevMagasin
     *
     * @param string $abrevMagasin
     * @return Magasins
     */
    public function setAbrevMagasin($abrevMagasin)
    {
        $this->abrevMagasin = $abrevMagasin;

        return $this;
    }

    /**
     * Get abrevMagasin
     *
     * @return string 
     */
    public function getAbrevMagasin()
    {
        return $this->abrevMagasin;
    }

    /**
     * Set idMagEnseigne
     *
     * @param integer $idMagEnseigne
     * @return Magasins
     */
    public function setIdMagEnseigne($idMagEnseigne)
    {
        $this->idMagEnseigne = $idMagEnseigne;

        return $this;
    }

    /**
     * Get idMagEnseigne
     *
     * @return integer 
     */
    public function getIdMagEnseigne()
    {
        return $this->idMagEnseigne;
    }

    /**
     * Set idStock
     *
     * @param integer $idStock
     * @return Magasins
     */
    public function setIdStock($idStock)
    {
        $this->idStock = $idStock;

        return $this;
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
     * Set idTarif
     *
     * @param integer $idTarif
     * @return Magasins
     */
    public function setIdTarif($idTarif)
    {
        $this->idTarif = $idTarif;

        return $this;
    }

    /**
     * Get idTarif
     *
     * @return integer 
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }

    /**
     * Set modeVente
     *
     * @param string $modeVente
     * @return Magasins
     */
    public function setModeVente($modeVente)
    {
        $this->modeVente = $modeVente;

        return $this;
    }

    /**
     * Get modeVente
     *
     * @return string 
     */
    public function getModeVente()
    {
        return $this->modeVente;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Magasins
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
     * Get idMagasin
     *
     * @return integer 
     */
    public function getIdMagasin()
    {
        return $this->idMagasin;
    }
}
