<?php


namespace AppBundle\Controller\User\HostControl\Mgmt;

use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class HostControlRetrievalController extends ControllerService
{


    public function listBookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');
        $qb = $bookingRepo->findHostBooking($this->getUser(),$request->query->all());
        $bookings = $this->pagingBuilder($request,$qb);
        return $this->render('AppBundle:User/UserHost:list-booking.html.twig', [
            'bookings'=>$bookings
        ]);
    }


}
