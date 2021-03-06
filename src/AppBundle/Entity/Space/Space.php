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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpaceRepository")
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
        $this->location = new Location();
        $this->price = new Price();
        $this->dateBooking = new DateBooking();
        $gallery = new Gallery();
        $gallery->setName('gallery_space');
        $gallery->setContext('default');
        $gallery->setDefaultFormat('default');
        $gallery->setEnabled(1);
        $this->photo = $gallery;
        $this->enabled = false;
        $this->completedCreate = false;
        $this->instantBook = false;
    }

    /**
     * @var datetime
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    /**
     * @var string
     * @ORM\Column(name="name", type="string",nullable=true)
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
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country",cascade={"persist","remove"})
     */
    private $country;

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

    /**
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean")
     */
    private $enabled;

  /**
     * @var boolean
     * @ORM\Column(name="completed_create",type="boolean")
     */
    private $completedCreate;

    /**
     * @var boolean
     * @ORM\Column(name="instant_book",type="boolean")
     */
    private $instantBook;

    /**
     * @return boolean
     */
    public function isInstantBook()
    {
        return $this->instantBook;
    }

    /**
     * @param boolean $instantBook
     */
    public function setInstantBook($instantBook)
    {
        $this->instantBook = $instantBook;
    }
    



    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }



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
     * @var Booking
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Booking\Booking",mappedBy="space")
     */
    private $bookings;

    /**
     * @return Booking
     */
    public function getBookings()
    {
        return $this->bookings;
    }

    /**
     * @param Booking $bookings
     */
    public function setBookings($bookings)
    {
        $this->bookings = $bookings;
    }
    

    /**
     * @var string
     * @ORM\Column(name="shape",type="string",nullable=true)
     */
    private $shape;

    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     */
    public function setShape($shape)
    {
        $this->shape = $shape;
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

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return boolean
     */
    public function isCompletedCreate()
    {
        return $this->completedCreate;
    }

    /**
     * @param boolean $completedCreate
     */
    public function setCompletedCreate($completedCreate)
    {
        $this->completedCreate = $completedCreate;
    }

    
    


    
    
    


}

