<?php


namespace AppBundle\Controller\User\HostControl\Mgmt;

use AppBundle\Entity\Space\Space;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use AppBundle\Form\ReplyMessageType;

class HostControlRetrievalController extends ControllerService
{


    public function listBookingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');
        $qb = $bookingRepo->findHostBooking($this->getUser(),$request->query->all());
        $bookings = $this->pagingBuilder($request,$qb);
        return $this->render('AppBundle:User/HostControl:list-booking.html.twig', [
            'bookings'=>$bookings
        ]);
    }
    public function reviewedSpaceAction(Request $request,Space $space)
    {
        $form = $this->createForm(ReplyMessageType::class);
        return $this->render('AppBundle:User/HostControl:reviewed-space.html.twig', [
            'space'=>$space,
            'form'=>$form->createView(),
        ]);
    }
    public function transactionReportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');
        $qb = $bookingRepo->findHostTransaction($this->getUser(),$request->query->all());
        $bookings = $this->pagingBuilder($request,$qb);
        return $this->render('AppBundle:User/HostControl:transaction-report.html.twig', [
            'bookings'=>$bookings
        ]);
    }


}
