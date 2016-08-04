<?php


namespace AppBundle\Controller\User\Booking\Api;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Core\User;

class BookingApiController extends ControllerService
{
    public function checkAvailableBookingAction(Request $request,Space $space){
        if($request->isXmlHttpRequest()){
            $bookingType = $request->get('bookingType');
            if($bookingType == Booking::BOOKING_TYPE_DAILY){
                $fromDate = \DateTime::createFromFormat('m/d/Y', $request->get('fromDate'));
                $begin =$fromDate->format('Y-m-d');

                $toDate = \DateTime::createFromFormat('m/d/Y', $request->get('toDate'));
                $end =$toDate->format('Y-m-d');
            }elseif($bookingType == Booking::BOOKING_TYPE_WEEKLY){
                $period = $request->get('period');
                $fromDate = \DateTime::createFromFormat('m/d/Y', $request->get('fromDate'));
                $begin = $fromDate->format('Y-m-d');
                $toDate = $fromDate->modify('+'.$period.' week');
                $end = $toDate->format('Y-m-d');
            }elseif($bookingType == Booking::BOOKING_TYPE_MONTHLY){
                $period = $request->get('period');
                $fromDate = \DateTime::createFromFormat('m/d/Y', $request->get('fromDate'));
                $begin = $fromDate->format('Y-m-d');
                $toDate = $fromDate->modify('+'.$period.' month');
                $end = $toDate->format('Y-m-d');
            }

            $available = $this->checkAvailableBooking($space,$begin,$end);
            return new JsonResponse(['status'=>true,'available'=>$available]);
        }
    }
}
