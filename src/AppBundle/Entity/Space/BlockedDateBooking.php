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
     * @ORM\Column(name="blocked_date",type="date")
     */
    private $blockedDate;

    /**
     * @var DateBooking
     * @ORM\ManyToOne(targetEntity="DateBooking")
     */
    
    private $dateBooking;
    

}

