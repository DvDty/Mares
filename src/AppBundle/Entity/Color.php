<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Color
 *
 * @ORM\Table(name="colors")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColorRepository")
 */
class Color
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product", mappedBy="colors")
     */
    private $products;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Color
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name_bg", type="string", length=255, unique=false)
     */
    private $nameBg;

    /**
     * @param $nameBg
     *
     * @return $this
     */
    public function setNameBg($nameBg)
    {
        $this->nameBg = $nameBg;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameBg()
    {
        return $this->nameBg;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="hex", type="string", length=255, unique=false)
     */
    private $hex;

    /**
     * @param $hex
     *
     * @return $this
     */
    public function setHex($hex)
    {
        $this->hex = $hex;

        return $this;
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }
}

