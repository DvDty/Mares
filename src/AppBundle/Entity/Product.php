<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="serialNumber", type="integer", nullable=true, unique=true)
     */
    private $serialNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $price = 0.00;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="live", type="boolean")
     */
    private $live = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addedOn", type="datetime")
     */
    private $addedOn;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Size", inversedBy="products")
     * @ORM\JoinTable(name="products_sizes",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="size_id", referencedColumnName="id")}
     *     )
     */
    private $sizes;

    /**
     * @param Size $size
     *
     * @return Product
     */
    public function addSize(Size $size)
    {
        $this->sizes[] = $size;

        return $this;
    }

    /**
     * @return array
     */
    public function getSizes()
    {
        $sizes = [];

        foreach ($this->sizes as $size) {
            /** @var $size Size */
            $sizes[] = $size;
        }

        return $sizes;
    }

    /**
     * @return $this
     */
    public function removeSizes()
    {
        unset($this->sizes);

        $this->sizes = [];

        return $this;
    }

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Color", inversedBy="products")
     * @ORM\JoinTable(name="products_colors",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="color_id", referencedColumnName="id")}
     *     )
     */
    private $colors;

    /**
     * @param Color $color
     *
     * @return Product
     */
    public function addColor(Color $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * @return $this
     */
    public function removeColors()
    {
        unset($this->colors);

        $this->colors = [];

        return $this;
    }

    /**
     * @return array
     */
    public function getColors()
    {
        $colors = [];

        foreach ($this->colors as $color) {
            /** @var $color Color */
            $colors[] = $color;
        }

        return $colors;
    }

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->addedOn = new \DateTime('now');
        $this->colors = new ArrayCollection();
        $this->sizes = new ArrayCollection();
    }

    /**
     * @return User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param User $addedBy
     *
     * @return Product
     */
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(name="addedById", referencedColumnName="id")
     */
    private $addedBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secondary_category", fetch="EAGER")
     */
    private $secondary_category;

    /**
     * @return mixed
     */
    public function getSecondaryCategory()
    {
        return $this->secondary_category;
    }

    /**
     * @param mixed $secondary_category
     */
    public function setSecondaryCategory($secondary_category)
    {
        $this->secondary_category = $secondary_category;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", fetch="EAGER")
     */
    private $brand;

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }


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
     * @return Product
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
     * Set serialNumber
     *
     * @param integer $serialNumber
     *
     * @return Product
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return int
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set live
     *
     * @param boolean $live
     *
     * @return Product
     */
    public function setLive($live)
    {
        $this->live = $live;

        return $this;
    }

    /**
     * Get live
     *
     * @return bool
     */
    public function isLive()
    {
        return $this->live;
    }


    /**
     * Set addedOn
     *
     * @param \DateTime $addedOn
     *
     * @return Product
     */
    public function setAddedOn($addedOn)
    {
        $this->addedOn = $addedOn;

        return $this;
    }

    /**
     * Get addedOn
     *
     * @return \DateTime
     */
    public function getAddedOn()
    {
        return $this->addedOn;
    }
}

