<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parc
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\ParcRepository")
 */
class Parc
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomParc", type="string", length=255, unique=true)
     */
    private $nomParc;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Filiere", mappedBy="parc" )
     */
    private $filieres;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Lanterne", mappedBy="children")
     */
    private $lanternes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lanternes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get nomParc
     *
     * @return string
     */
    public function getNomParc()
    {
        return $this->nomParc;
    }

    /**
     * Set nomParc
     *
     * @param string $nomParc
     * @return Parc
     */
    public function setNomParc($nomParc)
    {
        $this->nomParc = $nomParc;

        return $this;
    }

    /**
     * Add filieres
     *
     * @param \SS\FMBBundle\Entity\Filiere $filieres
     * @return Parc
     */
    public function addFiliere(\SS\FMBBundle\Entity\Filiere $filieres)
    {
        $this->filieres[] = $filieres;
        $filieres->setParc($this);

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

    /**
     * Add lanternes
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanternes
     * @return Parc
     */
    public function addLanterne(\SS\FMBBundle\Entity\Lanterne $lanternes)
    {
        $this->lanternes[] = $lanternes;

        return $this;
    }

    /**
     * Remove lanternes
     *
     * @param \SS\FMBBundle\Entity\Lanterne $lanternes
     */
    public function removeLanterne(\SS\FMBBundle\Entity\Lanterne $lanternes)
    {
        $this->lanternes->removeElement($lanternes);
    }

    /**
     * Get lanternes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanternes()
    {
        return $this->lanternes;
    }
}
