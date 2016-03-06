<?php

namespace SS\FMBBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="lanterne")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Entity\LanterneRepository")
 */
class Lanterne
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=64)
     */
    private $title;


    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="lanternes")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Poche", mappedBy="lanterne")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set root
     *
     * @param \SS\FMBBundle\Entity\Parc $root
     * @return Lanterne
     */
    public function setRoot(\SS\FMBBundle\Entity\Parc $root = null)
    {
        $this->root = $root;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Lanterne
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Lanterne
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Lanterne
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Add children
     *
     * @param \SS\FMBBundle\Entity\Poche $children
     * @return Lanterne
     */
    public function addChild(\SS\FMBBundle\Entity\Poche $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \SS\FMBBundle\Entity\Poche $children
     */
    public function removeChild(\SS\FMBBundle\Entity\Poche $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
