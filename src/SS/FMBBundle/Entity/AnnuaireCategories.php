<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnuaireCategories
 *
 * @ORM\Table(name="annuaire_categories")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AnnuaireCategories
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_categorie", type="string", length=32, nullable=false)
     */
    private $libCategorie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ordre", type="boolean", nullable=false)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="app_tarifs", type="string", nullable=false)
     */
    private $appTarifs;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie", type="smallint")
     * @ORM\Id
     */
    private $idCategorie;


    /**
     * Set libCategorie
     *
     * @param string $libCategorie
     * @return AnnuaireCategories
     */
    public function setLibCategorie($libCategorie)
    {
        $this->libCategorie = $libCategorie;

        return $this;
    }

    /**
     * Get libCategorie
     *
     * @return string
     */
    public function getLibCategorie()
    {
        return $this->libCategorie;
    }

    /**
     * Set ordre
     *
     * @param boolean $ordre
     * @return AnnuaireCategories
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return boolean
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set appTarifs
     *
     * @param string $appTarifs
     * @return AnnuaireCategories
     */
    public function setAppTarifs($appTarifs)
    {
        $this->appTarifs = $appTarifs;

        return $this;
    }

    /**
     * Get appTarifs
     *
     * @return string
     */
    public function getAppTarifs()
    {
        return $this->appTarifs;
    }

    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }
    /**
     * @ORM\PrePersist
     */
    public function generateIdCategorie()
    {
        $this->idCategorie = uniqid();
    }

    /**
     * Set idCategorie
     *
     * @param integer $idCategorie
     * @return AnnuaireCategories
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }
}
