<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $owner;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", fetch="EAGER")
     */
    private $product;

    /**
     * @return Int
     */
    public function getQuantity(): Int
    {
        return $this->quantity;
    }

    /**
     * @param Int $quantity
     */
    public function setQuantity(Int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @var Int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Color
     *
     * fetch="EAGER"
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color")
     */
    private $color;

    /**
     * @var Size
     *
     * fetch="EAGER"
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Size")
     */
    private $size;

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @param Color $color
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

    /**
     * @param Size $size
     */
    public function setSize(Size $size)
    {
        $this->size = $size;
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
     * @param User $user
     *
     * @return Cart
     *
     * @internal param int $userId     *
     */
    public function setOwner(User $user) /*=null*/
    {
        $this->owner = $user;

        return $this;
    }

    /**
     * Set productId
     *
     * @param Product|null $product
     *
     * @return Cart
     *
     * @internal param int $productId
     *
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status")
     */
    private $status;

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posted_on", type="datetime")
     */
    private $postedOn;

    /**
     * @return \DateTime
     */
    public function getPostedOn(): \DateTime
    {
        return $this->postedOn;
    }

    /**
     * @param \DateTime $postedOn
     */
    public function setPostedOn(\DateTime $postedOn)
    {
        $this->postedOn = $postedOn;
    }
}

