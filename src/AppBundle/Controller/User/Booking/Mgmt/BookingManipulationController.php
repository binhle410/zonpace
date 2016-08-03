<?php

namespace AppBundle\Controller\User\Booking\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use AppBundle\Services\Booking\Mgmt\CreationStep\Creator;

class BookingManipulationController extends ControllerService
{

    public function stepAction(Request $request,$step,Space $space,Booking $booking=null)
    {
        if(!$booking){
            $booking = new Booking();
            $booking->setUser($this->getUser());
        }
        $creator = Creator::getInstance($space,$booking, $this->container);
        if (in_array($step, array('0','1', '2', '3', '4', '5', '6', '7', '8', '9', 'x'))) {
            return $creator->process($step);
        }
    }
    

}
