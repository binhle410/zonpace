<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity\Core;

use Application\Sonata\MediaBundle\Entity\Media;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserWishlistRepository")
 * @ORM\Table(name="core__user_wishlist")
 */
class UserWishlist
{


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var datetime
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User")
     */
    private $user;


    /**
     * @var \AppBundle\Entity\Space\Space
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Space\Space")
     */
    private $space;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \AppBundle\Entity\Space\Space
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * @param \AppBundle\Entity\Space\Space $space
     */
    public function setSpace($space)
    {
        $this->space = $space;
    }
    



}