<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdressesTypes
 *
 * @ORM\Table(name="adresses_types")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class AdressesTypes
{
    /**
     * @var string
     *
     * @ORM\Column(name="adresse_type", type="string", length=64, nullable=false)
     */
    private $adresseType;

    /**
     * @var integer
     *
     * @ORM\Column(name="defaut", type="smallint", nullable=false)
     */
    private $defaut;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_adresse_type", type="smallint")
     * @ORM\Id
     */
    private $idAdresseType;



    /**
     * Set adresseType
     *
     * @param string $adresseType
     * @return AdressesTypes
     */
    public function setAdresseType($adresseType)
    {
        $this->adresseType = $adresseType;

        return $this;
    }

    /**
     * Get adresseType
     *
     * @return string 
     */
    public function getAdresseType()
    {
        return $this->adresseType;
    }

    /**
     * Set defaut
     *
     * @param integer $defaut
     * @return AdressesTypes
     */
    public function setDefaut($defaut)
    {
        $this->defaut = $defaut;

        return $this;
    }

    /**
     * Get defaut
     *
     * @return integer 
     */
    public function getDefaut()
    {
        return $this->defaut;
    }

    /**
     * Get idAdresseType
     *
     * @return integer 
     */
    public function getIdAdresseType()
    {
        return $this->idAdresseType;
    }
    /**
     * @ORM\PrePersist
     */
    public function generateIdAdresseType()
    {
        $this->idAdresseType = uniqid();
    }

    /**
     * Set idAdresseType
     *
     * @param integer $idAdresseType
     * @return AdressesTypes
     */
    public function setIdAdresseType($idAdresseType)
    {
        $this->idAdresseType = $idAdresseType;

        return $this;
    }
}
