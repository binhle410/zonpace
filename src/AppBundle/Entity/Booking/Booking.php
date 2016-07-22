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
    
    





    
    
    


}

