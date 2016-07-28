<?php


namespace AppBundle\Controller\User\HostControl\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Booking\BookingReviewMessage;
use AppBundle\Entity\Space\Space;
use AppBundle\Form\ReplyMessageType;
use AppBundle\Form\SpaceBookingReviewType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use Symfony\Component\HttpFoundation\Response;

class HostControlManipulationController extends ControllerService
{

    public function dashboardAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $spaceRepo = $em->getRepository('AppBundle:Space\Space');
        $numberTotalListing = $spaceRepo->getNumberTotalListing($this->getUser());
        $numberActiveListing = $spaceRepo->getNumberActiveListing($this->getUser());
        $unfinishedListingsQb = $spaceRepo->getUnfinishedListings($this->getUser());
        $unfinishedListings = $this->pagingBuilder($request,$unfinishedListingsQb);

        return $this->render('AppBundle:User/HostControl:dashboard.html.twig', [
            'numberTotalListing'=>$numberTotalListing,
            'numberActiveListing'=>$numberActiveListing,
            'unfinishedListings'=>$unfinishedListings
        ]);
    }
    public function replyReviewAction(Request $request,Booking $booking){
        $message = new BookingReviewMessage();
        $message->setUser($this->getUser());
        $message->setBooking($booking);
        $form = $this->createForm(ReplyMessageType::class,$message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('app_user_host_control_reviewed_space',['space'=>$booking->getSpace()->getId()]);
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            echo '<pre>';
            \Doctrine\Common\Util\Debug::dump($this->get('app.form_serializer')->serializeFormErrors($form, true, true));
        }
        
    }
    public function saveReceiptAction(Request $request,Booking $booking){
        $html = $this->renderView('AppBundle:User/HostControl:_receipt-template.html.twig', array(
            'booking'  => $booking
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,[
                'images' => true,
            ]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

}
