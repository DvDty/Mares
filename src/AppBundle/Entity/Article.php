<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views = 1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posted_on", type="date")
     */
    private $postedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500)
     */
    private $image;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $posted_by;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getPostedBy()
    {
        return $this->posted_by;
    }

    /**
     * @param User $posted_by
     */
    public function setPostedBy(User $posted_by)
    {
        $this->posted_by = $posted_by;
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Article
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set postedOn
     *
     * @param \DateTime $postedOn
     *
     * @return Article
     */
    public function setPostedOn($postedOn)
    {
        $this->postedOn = $postedOn;

        return $this;
    }

    /**
     * Get postedOn
     *
     * @return \DateTime
     */
    public function getPostedOn()
    {
        return $this->postedOn;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
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

    public function addView()
    {
        $this->views++;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = 0;
    //CURRENTLY USELESS, THE DELETE BUTTON DELETE THE ARTICLE!

    /**
     * @param $deleted
     *
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}

