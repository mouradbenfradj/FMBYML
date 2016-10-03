<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documents
 *
 * @ORM\Table(name="documents", indexes={@ORM\Index(name="id_type_doc", columns={"id_type_doc"}), @ORM\Index(name="id_etat_doc", columns={"id_etat_doc"}), @ORM\Index(name="ref_contact", columns={"ref_contact"}), @ORM\Index(name="ref_adr_contact", columns={"ref_adr_contact"}), @ORM\Index(name="id_pays_contact", columns={"id_pays_contact"}), @ORM\Index(name="code_affaire", columns={"code_affaire"})})
 * @ORM\Entity
 */
class Documents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_type_doc", type="smallint", nullable=true)
     */
    private $idTypeDoc;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_etat_doc", type="smallint", nullable=true)
     */
    private $idEtatDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="code_affaire", type="string", length=64, nullable=false)
     */
    private $codeAffaire;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_contact", type="string", length=32, nullable=true)
     */
    private $refContact;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_contact", type="string", length=128, nullable=false)
     */
    private $nomContact;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_adr_contact", type="string", length=32, nullable=true)
     */
    private $refAdrContact;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_contact", type="text", length=16777215, nullable=false)
     */
    private $adresseContact;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal_contact", type="string", length=9, nullable=false)
     */
    private $codePostalContact;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_contact", type="string", length=28, nullable=false)
     */
    private $villeContact;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pays_contact", type="smallint", nullable=true)
     */
    private $idPaysContact;

    /**
     * @var string
     *
     * @ORM\Column(name="app_tarifs", type="string", nullable=false)
     */
    private $appTarifs;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation_doc", type="datetime", nullable=false)
     */
    private $dateCreationDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="code_file", type="string", length=32, nullable=false)
     */
    private $codeFile;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_doc", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refDoc;



    /**
     * Set idTypeDoc
     *
     * @param integer $idTypeDoc
     * @return Documents
     */
    public function setIdTypeDoc($idTypeDoc)
    {
        $this->idTypeDoc = $idTypeDoc;

        return $this;
    }

    /**
     * Get idTypeDoc
     *
     * @return integer 
     */
    public function getIdTypeDoc()
    {
        return $this->idTypeDoc;
    }

    /**
     * Set idEtatDoc
     *
     * @param integer $idEtatDoc
     * @return Documents
     */
    public function setIdEtatDoc($idEtatDoc)
    {
        $this->idEtatDoc = $idEtatDoc;

        return $this;
    }

    /**
     * Get idEtatDoc
     *
     * @return integer 
     */
    public function getIdEtatDoc()
    {
        return $this->idEtatDoc;
    }

    /**
     * Set codeAffaire
     *
     * @param string $codeAffaire
     * @return Documents
     */
    public function setCodeAffaire($codeAffaire)
    {
        $this->codeAffaire = $codeAffaire;

        return $this;
    }

    /**
     * Get codeAffaire
     *
     * @return string 
     */
    public function getCodeAffaire()
    {
        return $this->codeAffaire;
    }

    /**
     * Set refContact
     *
     * @param string $refContact
     * @return Documents
     */
    public function setRefContact($refContact)
    {
        $this->refContact = $refContact;

        return $this;
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
     * Set nomContact
     *
     * @param string $nomContact
     * @return Documents
     */
    public function setNomContact($nomContact)
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    /**
     * Get nomContact
     *
     * @return string 
     */
    public function getNomContact()
    {
        return $this->nomContact;
    }

    /**
     * Set refAdrContact
     *
     * @param string $refAdrContact
     * @return Documents
     */
    public function setRefAdrContact($refAdrContact)
    {
        $this->refAdrContact = $refAdrContact;

        return $this;
    }

    /**
     * Get refAdrContact
     *
     * @return string 
     */
    public function getRefAdrContact()
    {
        return $this->refAdrContact;
    }

    /**
     * Set adresseContact
     *
     * @param string $adresseContact
     * @return Documents
     */
    public function setAdresseContact($adresseContact)
    {
        $this->adresseContact = $adresseContact;

        return $this;
    }

    /**
     * Get adresseContact
     *
     * @return string 
     */
    public function getAdresseContact()
    {
        return $this->adresseContact;
    }

    /**
     * Set codePostalContact
     *
     * @param string $codePostalContact
     * @return Documents
     */
    public function setCodePostalContact($codePostalContact)
    {
        $this->codePostalContact = $codePostalContact;

        return $this;
    }

    /**
     * Get codePostalContact
     *
     * @return string 
     */
    public function getCodePostalContact()
    {
        return $this->codePostalContact;
    }

    /**
     * Set villeContact
     *
     * @param string $villeContact
     * @return Documents
     */
    public function setVilleContact($villeContact)
    {
        $this->villeContact = $villeContact;

        return $this;
    }

    /**
     * Get villeContact
     *
     * @return string 
     */
    public function getVilleContact()
    {
        return $this->villeContact;
    }

    /**
     * Set idPaysContact
     *
     * @param integer $idPaysContact
     * @return Documents
     */
    public function setIdPaysContact($idPaysContact)
    {
        $this->idPaysContact = $idPaysContact;

        return $this;
    }

    /**
     * Get idPaysContact
     *
     * @return integer 
     */
    public function getIdPaysContact()
    {
        return $this->idPaysContact;
    }

    /**
     * Set appTarifs
     *
     * @param string $appTarifs
     * @return Documents
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
     * Set description
     *
     * @param string $description
     * @return Documents
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreationDoc
     *
     * @param \DateTime $dateCreationDoc
     * @return Documents
     */
    public function setDateCreationDoc($dateCreationDoc)
    {
        $this->dateCreationDoc = $dateCreationDoc;

        return $this;
    }

    /**
     * Get dateCreationDoc
     *
     * @return \DateTime 
     */
    public function getDateCreationDoc()
    {
        return $this->dateCreationDoc;
    }

    /**
     * Set codeFile
     *
     * @param string $codeFile
     * @return Documents
     */
    public function setCodeFile($codeFile)
    {
        $this->codeFile = $codeFile;

        return $this;
    }

    /**
     * Get codeFile
     *
     * @return string 
     */
    public function getCodeFile()
    {
        return $this->codeFile;
    }

    /**
     * Get refDoc
     *
     * @return string 
     */
    public function getRefDoc()
    {
        return $this->refDoc;
    }
}
