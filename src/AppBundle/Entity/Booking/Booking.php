<?php

namespace AppBundle\Entity\Booking;

use AppBundle\Entity\Core\User;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Table(name="booking__booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
{

    const STATUS_PENDING ='PENDING';
    const STATUS_CANCELLED ='CANCELLED';
    const STATUS_SUCCESS ='SUCCESS'; //Active , Completed
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
        $this->isReview = false;
    }

    /**
     * @var string
     * @ORM\Column(name="status",type="string")
     */
    private $status;

    /**
     * @var datetime
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    /**
     * @var date
     * @ORM\Column(name="date_from", type="date",nullable=true)
     */
    private $dateFrom;
    /**
     * @var date
     * @ORM\Column(name="date_to", type="date",nullable=true)
     */
    private $dateTo;

    /**
     * @var float
     * @ORM\Column(name="total_price",type="float")
     */
    private $totalPrice;

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
     * @var integer
     * @ORM\Column(name="rating_location",type="integer",options={"default"=0})
     */
    private $ratingLocation;
    /**
     * @var integer
     * @ORM\Column(name="rating_communication",type="integer",options={"default"=0})
     */
    private $ratingCommunication;


    /**
     * @var boolean
     * @ORM\Column(name="is_review",type="boolean",options={"default"=0})
     */
    private $isReview;


    /**
     * @var BookingReviewMessage
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Booking\BookingReviewMessage",mappedBy="booking",orphanRemoval=true,cascade={"merge","persist","remove"})
     */
    private $bookingReviewMessages;

    /**
     * @return BookingReviewMessage
     */
    public function getBookingReviewMessages()
    {
        return $this->bookingReviewMessages;
    }

    /**
     * @param BookingReviewMessage $bookingReviewMessages
     */
    public function setBookingReviewMessages($bookingReviewMessages)
    {
        $this->bookingReviewMessages = $bookingReviewMessages;
    }
    

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    
    /**
     * @return string
     */
    public function getGuestNote()
    {
        return $this->guestNote;
    }

    /**
     * @param string $guestNote
     */
    public function setGuestNote($guestNote)
    {
        $this->guestNote = $guestNote;
    }
    

    /**
     * @return boolean
     */
    public function isIsReview()
    {
        return $this->isReview;
    }

    /**
     * @param boolean $isReview
     */
    public function setIsReview($isReview)
    {
        $this->isReview = $isReview;
    }

        /**
     * @param boolean $isReview
     */
    public function getIsReview()
    {
        return $this->isReview;
    }



    /**
     * @return int
     */
    public function getRatingLocation()
    {
        return $this->ratingLocation;
    }

    /**
     * @param int $ratingLocation
     */
    public function setRatingLocation($ratingLocation)
    {
        $this->ratingLocation = $ratingLocation;
    }

    /**
     * @return int
     */
    public function getRatingCommunication()
    {
        return $this->ratingCommunication;
    }

    /**
     * @param int $ratingCommunication
     */
    public function setRatingCommunication($ratingCommunication)
    {
        $this->ratingCommunication = $ratingCommunication;
    }


    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
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

    /**
     * @return date
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param date $dateTo
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return date
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param date $dateFrom
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
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
    public function getBookingID()
    {
        return $this->bookingID;
    }

    /**
     * @param string $bookingID
     */
    public function setBookingID($bookingID)
    {
        $this->bookingID = $bookingID;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    





    
    
    


}

