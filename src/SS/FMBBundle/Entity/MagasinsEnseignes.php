<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagasinsEnseignes
 *
 * @ORM\Table(name="magasins_enseignes")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class MagasinsEnseignes
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_enseigne", type="string", length=255, nullable=false)
     */
    private $libEnseigne;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_mag_enseigne", type="smallint")
     * @ORM\Id
     */
    private $idMagEnseigne;


    /**
     * Set libEnseigne
     *
     * @param string $libEnseigne
     * @return MagasinsEnseignes
     */
    public function setLibEnseigne($libEnseigne)
    {
        $this->libEnseigne = $libEnseigne;

        return $this;
    }

    /**
     * Get libEnseigne
     *
     * @return string
     */
    public function getLibEnseigne()
    {
        return $this->libEnseigne;
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
     * @ORM\PrePersist
     */
    public function generateIdMagEnseigne()
    {
        $this->idMagEnseigne = uniqid();
    }

    /**
     * Set idMagEnseigne
     *
     * @param integer $idMagEnseigne
     * @return MagasinsEnseignes
     */
    public function setIdMagEnseigne($idMagEnseigne)
    {
        $this->idMagEnseigne = $idMagEnseigne;

        return $this;
    }
}
