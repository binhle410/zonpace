<?php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="core__message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
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
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="message",type="text"))
     */
    private $message;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User")
     */
    private $messageTo;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User")
     */

    private $messageFrom;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Message", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Message", inversedBy="children")
     */
    private $parent;


    /**
     * @return int
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
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return User
     */
    public function getMessageTo()
    {
        return $this->messageTo;
    }

    /**
     * @param User $messageTo
     */
    public function setMessageTo($messageTo)
    {
        $this->messageTo = $messageTo;
    }

    /**
     * @return User
     */
    public function getMessageFrom()
    {
        return $this->messageFrom;
    }

    /**
     * @param User $messageFrom
     */
    public function setMessageFrom($messageFrom)
    {
        $this->messageFrom = $messageFrom;
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
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    
    
    


    
    
    
}

