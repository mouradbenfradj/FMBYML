<?php

namespace SS\FMBBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="lanterne")
 * @ORM\Entity(repositoryClass="SS\FMBBundle\Repository\LanterneRepository")
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
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="SS\FMBBundle\Entity\Parc", inversedBy="lanternes")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="SS\FMBBundle\Entity\Poche", mappedBy="lanterne")
     * @ORM\OrderBy({"poche" = "ASC"})
     */
    private $poche;

}
