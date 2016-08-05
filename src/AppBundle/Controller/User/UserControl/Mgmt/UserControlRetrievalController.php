<?php


namespace AppBundle\Controller\User\UserControl\Mgmt;

use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class UserControlRetrievalController extends ControllerService
{


    public function listBookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');
        $qb = $bookingRepo->findMyBooking($this->getUser(),$request->query->all());
        $bookings = $this->pagingBuilder($request,$qb);
        return $this->render('AppBundle:User/UserControl:list-booking.html.twig', [
            'bookings'=>$bookings
        ]);
    }
    public function listInboxAction(Request $request)
    {
        $em =$this->getDoctrine()->getManager();
        $messageRepo = $em->getRepository('AppBundle:Core\Message');
        $qb = $messageRepo->findMyInbox($this->getUser());
        $messages = $this->pagingBuilder($request,$qb);
        return $this->render('AppBundle:User/UserControl:list-.html.twig', [
            'messages'=>$messages
        ]);
    }


}
