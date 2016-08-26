<?php

namespace SS\FMBBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresses
 *
 * @ORM\Table(name="adresses", indexes={@ORM\Index(name="id_pays", columns={"id_pays"}), @ORM\Index(name="ref_contact", columns={"ref_contact"}), @ORM\Index(name="id_type_adresse", columns={"id_type_adresse"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Adresses
{
    /**
     * @var string
     *
     * @ORM\Column(name="lib_adresse", type="string", length=128, nullable=false)
     */
    private $libAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="text_adresse", type="string", length=160, nullable=false)
     */
    private $textAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=9, nullable=false)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=28, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="blob", length=16777215, nullable=false)
     */
    private $note;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="smallint", nullable=false)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_adresse", type="string", length=32)
     * @ORM\Id
     */
    private $refAdresse;

    /**
     * @var \SS\FMBBundle\Entity\AdressesTypes
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\AdressesTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_adresse", referencedColumnName="id_adresse_type")
     * })
     */
    private $idTypeAdresse;

    /**
     * @var \SS\FMBBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pays", referencedColumnName="id_pays")
     * })
     */
    private $idPays;

    /**
     * @var \SS\FMBBundle\Entity\Annuaire
     *
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Annuaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_contact", referencedColumnName="ref_contact")
     * })
     */
    private $refContact;



    /**
     * Set libAdresse
     *
     * @param string $libAdresse
     * @return Adresses
     */
    public function setLibAdresse($libAdresse)
    {
        $this->libAdresse = $libAdresse;

        return $this;
    }

    /**
     * Get libAdresse
     *
     * @return string 
     */
    public function getLibAdresse()
    {
        return $this->libAdresse;
    }

    /**
     * Set textAdresse
     *
     * @param string $textAdresse
     * @return Adresses
     */
    public function setTextAdresse($textAdresse)
    {
        $this->textAdresse = $textAdresse;

        return $this;
    }

    /**
     * Get textAdresse
     *
     * @return string 
     */
    public function getTextAdresse()
    {
        return $this->textAdresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Adresses
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Adresses
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Adresses
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
     * Set ordre
     *
     * @param integer $ordre
     * @return Adresses
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Get refAdresse
     *
     * @return string 
     */
    public function getRefAdresse()
    {
        return $this->refAdresse;
    }

    /**
     * Set idTypeAdresse
     *
     * @param \SS\FMBBundle\Entity\AdressesTypes $idTypeAdresse
     * @return Adresses
     */
    public function setIdTypeAdresse(\SS\FMBBundle\Entity\AdressesTypes $idTypeAdresse = null)
    {
        $this->idTypeAdresse = $idTypeAdresse;

        return $this;
    }

    /**
     * Get idTypeAdresse
     *
     * @return \SS\FMBBundle\Entity\AdressesTypes
     */
    public function getIdTypeAdresse()
    {
        return $this->idTypeAdresse;
    }

    /**
     * Set idPays
     *
     * @param \SS\FMBBundle\Entity\Pays $idPays
     * @return Adresses
     */
    public function setIdPays(\SS\FMBBundle\Entity\Pays $idPays = null)
    {
        $this->idPays = $idPays;

        return $this;
    }

    /**
     * Get idPays
     *
     * @return \SS\FMBBundle\Entity\Pays
     */
    public function getIdPays()
    {
        return $this->idPays;
    }

    /**
     * Set refContact
     *
     * @param \SS\FMBBundle\Entity\Annuaire $refContact
     * @return Adresses
     */
    public function setRefContact(\SS\FMBBundle\Entity\Annuaire $refContact = null)
    {
        $this->refContact = $refContact;

        return $this;
    }

    /**
     * Get refContact
     *
     * @return \SS\FMBBundle\Entity\Annuaire
     */
    public function getRefContact()
    {
        return $this->refContact;
    }
    /**
     * @ORM\PrePersist
     */
    public function generateRefAdresse()
    {
        $this->refAdresse = uniqid();
    }

    /**
     * Set refAdresse
     *
     * @param string $refAdresse
     * @return Adresses
     */
    public function setRefAdresse($refAdresse)
    {
        $this->refAdresse = $refAdresse;

        return $this;
    }
}
