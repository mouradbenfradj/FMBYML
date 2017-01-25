<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Processus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Entity\ProcessusRepository")
 */
class Processus
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
     * @ORM\Column(name="nomProcessus", type="string", length=255)
     */
    private $nomProcessus;



    /**
     * @var boolean
     *
     * @ORM\Column(name="passation", type="boolean")
     */
    private $passation;

    /**
     * @var array
     *
     * @ORM\Column(name="duree", type="array")
     */
    private $duree = array();

    /**
     * @var array
     *
     * @ORM\Column(name="alerteRouge", type="array")
     */
    private $alerteRouge = array();

    /**
     * @var array
     *
     * @ORM\Column(name="alerteJaune", type="array")
     */
    private $alerteJaune = array();



    /**
     * @var string
     *
     * @ORM\Column(name="articleSortie", type="string", length=255)
     */
    private $articleSortie;

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
     * Set nomProcessus
     *
     * @param string $nomProcessus
     * @return Processus
     */
    public function setNomProcessus($nomProcessus)
    {
        $this->nomProcessus = $nomProcessus;

        return $this;
    }

    /**
     * Get nomProcessus
     *
     * @return string 
     */
    public function getNomProcessus()
    {
        return $this->nomProcessus;
    }

    /**
     * Set passation
     *
     * @param boolean $passation
     * @return Processus
     */
    public function setPassation($passation)
    {
        $this->passation = $passation;

        return $this;
    }

    /**
     * Get passation
     *
     * @return boolean 
     */
    public function getPassation()
    {
        return $this->passation;
    }

    /**
     * Set duree
     *
     * @param array $duree
     * @return Processus
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return array 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set alerteRouge
     *
     * @param array $alerteRouge
     * @return Processus
     */
    public function setAlerteRouge($alerteRouge)
    {
        $this->alerteRouge = $alerteRouge;

        return $this;
    }

    /**
     * Get alerteRouge
     *
     * @return array 
     */
    public function getAlerteRouge()
    {
        return $this->alerteRouge;
    }

    /**
     * Set alerteJaune
     *
     * @param array $alerteJaune
     * @return Processus
     */
    public function setAlerteJaune($alerteJaune)
    {
        $this->alerteJaune = $alerteJaune;

        return $this;
    }

    /**
     * Get alerteJaune
     *
     * @return array 
     */
    public function getAlerteJaune()
    {
        return $this->alerteJaune;
    }

    /**
     * Set articleSortie
     *
     * @param string $articleSortie
     * @return Processus
     */
    public function setArticleSortie($articleSortie)
    {
        $this->articleSortie = $articleSortie;

        return $this;
    }

    /**
     * Get articleSortie
     *
     * @return string 
     */
    public function getArticleSortie()
    {
        return $this->articleSortie;
    }
}
