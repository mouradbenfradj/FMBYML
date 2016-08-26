<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annuaire
 *
 * @ORM\Table(name="annuaire", indexes={@ORM\Index(name="nom", columns={"nom"}), @ORM\Index(name="id_civilite", columns={"id_civilite"}), @ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Annuaire
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=128, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=32, nullable=false)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="tva_intra", type="string", length=32, nullable=false)
     */
    private $tvaIntra;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="blob", length=16777215, nullable=false)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=false)
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_archivage", type="datetime", nullable=true)
     */
    private $dateArchivage;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_contact", type="string", length=32)
     * @ORM\Id
     */
    private $refContact;

    /**
     * @var \SS\FMBBundle\Entity\AnnuaireCategories
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\AnnuaireCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

    /**
     * @var \SS\FMBBundle\Entity\Civilites
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Civilites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_civilite", referencedColumnName="id_civilite")
     * })
     */
    private $idCivilite;



    /**
     * Set nom
     *
     * @param string $nom
     * @return Annuaire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set siret
     *
     * @param string $siret
     * @return Annuaire
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set tvaIntra
     *
     * @param string $tvaIntra
     * @return Annuaire
     */
    public function setTvaIntra($tvaIntra)
    {
        $this->tvaIntra = $tvaIntra;

        return $this;
    }

    /**
     * Get tvaIntra
     *
     * @return string 
     */
    public function getTvaIntra()
    {
        return $this->tvaIntra;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Annuaire
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Annuaire
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return Annuaire
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set dateArchivage
     *
     * @param \DateTime $dateArchivage
     * @return Annuaire
     */
    public function setDateArchivage($dateArchivage)
    {
        $this->dateArchivage = $dateArchivage;

        return $this;
    }

    /**
     * Get dateArchivage
     *
     * @return \DateTime 
     */
    public function getDateArchivage()
    {
        return $this->dateArchivage;
    }

    /**
     * Get refContact
     *
     * @return string 
     */
    public function getRefContact()
    {
        return $this->refContact;
    }

    /**
     * Set idCategorie
     *
     * @param \SS\FMBBundle\Entity\AnnuaireCategories $idCategorie
     * @return Annuaire
     */
    public function setIdCategorie(\SS\FMBBundle\Entity\AnnuaireCategories $idCategorie = null)
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    /**
     * Get idCategorie
     *
     * @return \SS\FMBBundle\Entity\AnnuaireCategories
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set idCivilite
     *
     * @param \SS\FMBBundle\Entity\Civilites $idCivilite
     * @return Annuaire
     */
    public function setIdCivilite(\SS\FMBBundle\Entity\Civilites $idCivilite = null)
    {
        $this->idCivilite = $idCivilite;

        return $this;
    }

    /**
     * Get idCivilite
     *
     * @return \SS\FMBBundle\Entity\Civilites
     */
    public function getIdCivilite()
    {
        return $this->idCivilite;
    }
    /**
     * @ORM\PrePersist
     */
    public function generateRefContact()
    {
        $this->refContact = uniqid();
    }


    /**
     * Set refContact
     *
     * @param string $refContact
     * @return Annuaire
     */
    public function setRefContact($refContact)
    {
        $this->refContact = $refContact;

        return $this;
    }
}
