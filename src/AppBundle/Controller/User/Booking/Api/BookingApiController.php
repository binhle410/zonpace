<?php


namespace AppBundle\Controller\User\Booking\Api;

use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Core\User;

class BookingApiController extends ControllerService
{

    public function getPriceBookingAction(Request $request){
        if($request->isXmlHttpRequest()){
            $fromDate = \DateTime::createFromFormat('m/d/Y', $request->get('fromDate'));
            $fromDate =$fromDate->format('Y-m-d');

            $toDate = \DateTime::createFromFormat('m/d/Y', $request->get('toDate'));
            $toDate =$toDate->format('Y-m-d');

            $pricePerDate = $request->get('pricePerDay');
            $price = $this->getPriceBooking($fromDate,$toDate,$pricePerDate,1);
            return new JsonResponse(['status'=>true,'price'=>$price]);
        }
    }
}
