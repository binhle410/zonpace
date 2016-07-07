<?php

namespace AppBundle\Entity\Space;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="space__date_booking")
 * @ORM\Entity
 */
class DateBooking
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
        $this->blockedDateBookings = new ArrayCollection();
    }

    /**
     * @var date
     * @ORM\Column(name="date_from",type="date",nullable=true)
     */
    private $dateFrom;
    /**
     * @var date
     * @ORM\Column(name="date_to",type="date",nullable=true)
     */
    private $dateTo;

    /**
     * @var BlockedDateBooking
     * @ORM\OneToMany(targetEntity="BlockedDateBooking",mappedBy="dateBooking",orphanRemoval=true,cascade={"merge","persist","remove"})
     */
    private $blockedDateBookings;

    public function addBlockedDateBooking(BlockedDateBooking $blockedDateBooking){
        $this->blockedDateBookings->add($blockedDateBooking);
        $blockedDateBooking->setBlockedDate($this);
        return $this;
    }
    public function removeBlockedDateBooking(BlockedDateBooking $blockedDateBooking){
        $this->blockedDateBookings->removeElement($blockedDateBooking);
        $blockedDateBooking->setBlockedDate(null);
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
     * @return BlockedDateBooking
     */
    public function getBlockedDateBookings()
    {
        return $this->blockedDateBookings;
    }

    /**
     * @param BlockedDateBooking $blockedDateBookings
     */
    public function setBlockedDateBookings($blockedDateBookings)
    {
        $this->blockedDateBookings = $blockedDateBookings;
    }



}

