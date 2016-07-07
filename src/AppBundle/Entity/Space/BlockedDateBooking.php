<?php

namespace AppBundle\Entity\Space;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="space__blocked_date_booking")
 * @ORM\Entity
 */
class BlockedDateBooking
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
     * @var date
     * @ORM\Column(name="blocked_date",type="date",nullable=true)
     */
    private $blockedDate;

    /**
     * @var DateBooking
     * @ORM\ManyToOne(targetEntity="DateBooking")
     */
    
    private $dateBooking;

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
    public function getBlockedDate()
    {
        return $this->blockedDate;
    }

    /**
     * @param date $blockedDate
     */
    public function setBlockedDate($blockedDate)
    {
        $this->blockedDate = $blockedDate;
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
    
    

}

