<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parc
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Entity\ParcRepository")
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
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Filiere", mappedBy="parc")
     */
    private $filieres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieres = new \Doctrine\Common\Collections\ArrayCollection();
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
}
