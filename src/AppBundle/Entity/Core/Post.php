<?php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="core__post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
{

    const TYPE_NEW = 'NEW';
    const TYPE_BLOG = 'BLOG';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @var datetime
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(name="title",type="string"))
     */
    private $title;
    /**
     * @var string
     * @ORM\Column(name="short_description",type="text"))
     */
    private $shortDescription;

    /**
     * @var string
     * @ORM\Column(name="description",type="text"))
     */
    private $description;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     */
    private $category;

    /**
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean"))
     */
    private $enabled;


    /**
     * @var string
     * @ORM\Column(name="type",type="string"))
     */
    private $type;

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
    

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }



    
    


    
    
    
}

