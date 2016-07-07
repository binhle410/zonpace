<?php

namespace AppBundle\Entity\Space;

use AppBundle\Entity\Core\User;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Table(name="space__space")
 * @ORM\Entity
 */
class Space
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
        $this->features = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @var datetime
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

    /**
     * @var Gallery
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery",cascade={"persist","remove"})
     */
    private $photo;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location",cascade={"persist","remove"})
     */
    private $location;
    /**
     * @var Price
     * @ORM\ManyToOne(targetEntity="Price",cascade={"persist","remove"})
     */
    private $price;

    /**
     * @var DateBooking
     * @ORM\ManyToOne(targetEntity="DateBooking",cascade={"persist","remove"})
     */
    private $dateBooking;

    /**
     * @var Feature
     * @ORM\ManyToMany(targetEntity="Feature")
     * @ORM\JoinTable(name="space__space_feature",
     *      joinColumns={@ORM\JoinColumn(name="space_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="feature_id", referencedColumnName="id")}
     *      )
     */
    private $features;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User")
     */
    private $user;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    public function getSlug()
    {
        return $this->slug;
    }



    public function addFeature(Feature $feature){
        $this->features->add($feature);
        return $this;
    }
    public function removeFeature(Feature $feature){
        $this->features->removeElement($feature);
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Gallery
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param Gallery $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return DateBooking
     */
    public function getDateBooking()
    {
        return $this->dateBooking;
    }

    /**
     * @param DateBooking $dateBooking
     */
    public function setDateBooking($dateBooking)
    {
        $this->dateBooking = $dateBooking;
    }

    /**
     * @return Feature
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param Feature $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
    


    
    
    


}
