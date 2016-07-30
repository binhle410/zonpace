<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep;


use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;

abstract class Step extends ControllerService implements StepInterface
{

    protected $space;
    protected $booking;

    function __construct(Space $space,Booking $booking)
    {
        $this->space = $space;
        $this->booking = $booking;
    }

}
