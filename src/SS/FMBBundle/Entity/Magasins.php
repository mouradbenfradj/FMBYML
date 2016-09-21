<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasins
 *
 * @ORM\Table(name="magasins", indexes={@ORM\Index(name="id_stock", columns={"id_stock"}), @ORM\Index(name="id_tarif", columns={"id_tarif"}), @ORM\Index(name="actif", columns={"actif"}), @ORM\Index(name="id_mag_enseigne", columns={"id_mag_enseigne"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idMagasin;

    /**
     * @var \SS\FMBBundle\Entity\MagasinsEnseignes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\MagasinsEnseignes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mag_enseigne", referencedColumnName="id_mag_enseigne")
     * })
     */
    private $idMagEnseigne;

    /**
     * @var \SS\FMBBundle\Entity\TarifsListes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\TarifsListes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tarif", referencedColumnName="id_tarif")
     * })
     */
    private $idTarif;

    /**
     * @var \SS\FMBBundle\Entity\Stocks
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Stocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock")
     * })
     */
    private $idStock;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Filiere", mappedBy="parc" ,cascade={"persist","remove"})
     */
    private $filieres;


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
     * Set idMagEnseigne
     *
     * @param \SS\FMBBundle\Entity\MagasinsEnseignes $idMagEnseigne
     * @return Magasins
     */
    public function setIdMagEnseigne(\SS\FMBBundle\Entity\MagasinsEnseignes $idMagEnseigne = null)
    {
        $this->idMagEnseigne = $idMagEnseigne;

        return $this;
    }

    /**
     * Get idMagEnseigne
     *
     * @return \SS\FMBBundle\Entity\MagasinsEnseignes
     */
    public function getIdMagEnseigne()
    {
        return $this->idMagEnseigne;
    }

    /**
     * Set idTarif
     *
     * @param \SS\FMBBundle\Entity\TarifsListes $idTarif
     * @return Magasins
     */
    public function setIdTarif(\SS\FMBBundle\Entity\TarifsListes $idTarif = null)
    {
        $this->idTarif = $idTarif;

        return $this;
    }

    /**
     * Get idTarif
     *
     * @return \SS\FMBBundle\Entity\TarifsListes
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }

    /**
     * Set idStock
     *
     * @param \SS\FMBBundle\Entity\Stocks $idStock
     * @return Magasins
     */
    public function setIdStock(\SS\FMBBundle\Entity\Stocks $idStock = null)
    {
        $this->idStock = $idStock;

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
     * Get idMagasin
     *
     * @return integer
     */
    public function getIdMagasin()
    {
        return $this->idMagasin;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     * @return Magasins
     */
    public function addFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres[] = $filieres;

        return $this;
    }

    /**
     * Remove filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     */
    public function removeFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres->removeElement($filieres);
    }

    /**
     * Get filieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilieres()
    {
        return $this->filieres;
    }

    public function __toString()
    {
        return $this->getAbrevMagasin();
    }
}