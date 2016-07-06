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
     * @ORM\Column(name="date_from",type="date")
     */
    private $dateFrom;
    /**
     * @var date
     * @ORM\Column(name="date_to",type="date")
     */
    private $dateTo;

    /**
     * @var BlockedDateBooking
     * @ORM\OneToMany(targetEntity="BlockedDateBooking",mappedBy="dateBooking",orphanRemoval=true,cascade={"merge","persist","remove"})
     */
    private $blockedDateBookings;

    public function addBlockedDateBooking(BlockedDateBooking $blockedDateBooking){
        $this->blockedDateBookings->add($blockedDateBooking);
        return $this;
    }
    public function removeBlockedDateBooking(BlockedDateBooking $blockedDateBooking){
        $this->blockedDateBookings->removeElement($blockedDateBooking);
        return $this;
    }

}

