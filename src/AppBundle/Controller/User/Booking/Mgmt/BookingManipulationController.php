<?php

namespace AppBundle\Controller\User\Booking\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Core\UserWishlist;
use AppBundle\Entity\Space\Space;
use AppBundle\Form\PlotSpaceType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use AppBundle\Services\Booking\Mgmt\CreationStep\Creator;
use AppBundle\Entity\Core\Message;
use AppBundle\Form\InboxMessageType;

class BookingManipulationController extends ControllerService
{

    public function stepAction(Request $request, $step, Space $space, Booking $booking = null)
    {
        if (!$booking) {
            $booking = new Booking();
            $booking->setUser($this->getUser());
        }
        $creator = Creator::getInstance($space, $booking, $this->container);
        if (in_array($step, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'x'))) {
            return $creator->process($step);
        }
    }

    public function plotSpaceAction(Request $request, Space $space, Booking $booking = null, $type)
    {
        if ($booking == null) {
            $booking = new Booking();
        }
        $form = $this->createForm(PlotSpaceType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($type == 'user') {
                $booking->setSpace($space);
                $booking->setIsPlot(true);
                $booking->setUser($this->getUser());
                $booking->setStatusPlot(Booking::PLOT_PENDING);
            } else {
                $booking->setStatusPlot(Booking::PLOT_APPROVED);
            }
            $em->persist($booking);
            $em->flush();

            if ($type == 'user') {
                return $this->redirectToRoute('app_user_booking_create', [
                    'space' => $space->getId(),
                    'step' => 0
                ]);
            } else {
                $urlBooking = $this->generateUrl('app_user_booking_create',[
                    'space'=>$space->getId(),
                    'booking'=>$booking->getId(),
                    'step'=>1
                ]);
                $this->get('app.email_sender')->sendEmailOfferPlot($booking->getUser()->getEmail(),$urlBooking);
                return $this->redirectToRoute('app_user_host_control_list_booking', [
                ]);
            }
        }
        return $this->render('AppBundle:User/Booking:plot-space.html.twig', array(
            'type' => $type,
            'booking' => $booking,
            'space' => $space,
            'form' => $form->createView()
        ));
    }

    public function approvePlotAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $booking->setStatusPlot(Booking::PLOT_APPROVED);
        $em->persist($booking);
        $em->flush();
        $urlBooking = $this->generateUrl('app_user_booking_create',[
            'space'=>$booking->getSpace()->getId(),
            'booking'=>$booking->getId(),
            'step'=>1
        ]);
        $this->get('app.email_sender')->sendEmailOfferPlot($booking->getUser()->getEmail(),$urlBooking);
        return $this->redirectToRoute('app_user_host_control_list_booking', [
        ]);
    }
    public function rejectPlotAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $booking->setStatusPlot(Booking::PLOT_REJECTED);
        $em->persist($booking);
        $em->flush();
        return $this->redirectToRoute('app_user_host_control_list_booking', [
        ]);
    }

    public function enquireSpaceAction(Request $request,Space $space)
    {
        $em =$this->getDoctrine()->getManager();
        $message = new Message();
        $form = $this->createForm(InboxMessageType::class,$message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $message->setMessageFrom($this->getUser());
            $message->setMessageTo($space->getUser());
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('app_user_booking_create', [
                'space' => $space->getId(),
                'step' => 0
            ]);
        }

        return $this->render('AppBundle:User/Booking:enquire-space.html.twig', [
            'form'=>$form->createView(),
            'space'=>$space
        ]);
    }

    public function addToWishlistAction(Space $space)
    {
        $em = $this->getDoctrine()->getManager();
        $wishlist = new UserWishlist();
        $wishlist->setUser($this->getUser());
        $wishlist->setSpace($space);
        $em->persist($wishlist);
        $em->flush();
        return $this->redirectToRoute('app_user_booking_create', [
            'space' => $space->getId(),
            'step' => 0
        ]);
    }
    public function removeFromWishlistAction(Space $space,UserWishlist $userWishlist)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($userWishlist);
        $em->flush();
        return $this->redirectToRoute('app_user_booking_create', [
            'space' => $space->getId(),
            'step' => 0
        ]);
    }


}
