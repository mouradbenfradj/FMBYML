<?php

namespace SS\FMBBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\LanterneRepository")
 */
class Lanterne
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
     * @ORM\Column(name="nomLanterne", type="string", length=255)
     */
    private $nomLanterne;
    /**
     * @var integer
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="lanternes",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;
    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Poche", mappedBy="lanterne",cascade={"persist","remove"})
     */
    private $poches;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function generatePoche()
    {
        for ($i = 1; $i < ($this->nombre + 1); $i++) {
            $poche = new Poche();
            $poche->setEmplacement($i);
            $this->addPoch($poche);
        }
    }

    /**
     * Add poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     * @return Lanterne
     */
    public function addPoch(\SS\FMBBundle\Entity\Poche $poches)
    {
        $this->poches[] = $poches;
        $poches->setLanterne($this);

        return $this;
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
     * Get nomLanterne
     *
     * @return string
     */
    public function getNomLanterne()
    {
        return $this->nomLanterne;
    }

    /**
     * Set nomLanterne
     *
     * @param string $nomLanterne
     * @return Lanterne
     */
    public function setNomLanterne($nomLanterne)
    {
        $this->nomLanterne = $nomLanterne;

        return $this;
    }

    /**
     * Get parc
     *
     * @return \SS\FMBBundle\Entity\Parc
     */
    public function getParc()
    {
        return $this->parc;
    }

    /**
     * Set parc
     *
     * @param \SS\FMBBundle\Entity\Parc $parc
     * @return Lanterne
     */
    public function setParc(\SS\FMBBundle\Entity\Parc $parc)
    {
        $this->parc = $parc;

        return $this;
    }

    /**
     * Remove poches
     *
     * @param \SS\FMBBundle\Entity\Poche $poches
     */
    public function removePoch(\SS\FMBBundle\Entity\Poche $poches)
    {
        $this->poches->removeElement($poches);
    }

    /**
     * Get poches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoches()
    {
        return $this->poches;
    }

    /**
     * Get nombre
     *
     * @return integer
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     * @return Lanterne
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
