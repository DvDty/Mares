<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secondary_category
 *
 * @ORM\Table(name="secondary_categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Secondary_categoryRepository")
 */
class Secondary_category
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
     * @return Secondary_category
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
     * @return string
     */
    function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", fetch="EAGER")
     */
    private $category;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
}

