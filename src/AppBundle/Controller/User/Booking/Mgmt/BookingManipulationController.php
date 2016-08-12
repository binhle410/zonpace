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

    /**
     * User create a plot , then host give a offer for user => approved
     *
     * @param Request $request
     * @param Space $space
     * @param $booking
     * @param $type
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function plotSpaceAction(Request $request, Space $space, $booking, $type)
    {
        if($booking == 0){
            $booking = new Booking();
        }else{
            $booking = $this->getDoctrine()->getRepository('AppBundle:Booking\Booking')->find($booking);
        }
        $form = $this->createForm(PlotSpaceType::class, $booking,['type'=>$type]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($type == 'user') {
                $booking->setSpace($space);
                $booking->setIsPlot(true);
                $booking->setUser($this->getUser());
                $booking->setStatus(Booking::STATUS_PENDING);
                $booking->setStatusPlot(Booking::PLOT_PENDING);
                $booking->setSpaceInstantBook($space->isInstantBook());
                $em->persist($booking);

                //new a inbox message
                $message = new Message();
                $message->setMessageFrom($this->getUser());
                $message->setMessageTo($space->getUser());
                $message->setSpace($space);
                $message->getTitle('Message plot a space');
                $message->setMessage($form->get('message')->getData());
                $em->persist($message);
            } else {
                $booking->setStatusPlot(Booking::PLOT_APPROVED);
                $booking->setSpaceInstantBook(true);
                $em->persist($booking);
            }
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
                ],0);
                $data['url'] = $urlBooking;
                $data['space_name'] = $space->getName();
                $data['host_name'] = $this->getUser()->getFirstName() .' ' .$this->getUser()->getLastName();
                $data['user_name'] = $booking->getUser()->getFirstName() .' ' .$booking->getUser()->getLastName();
                $this->get('app.email_sender')->sendEmailOfferPlot($booking->getUser()->getEmail(),$data);
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

    /**
     * Not use this function anymore
     * @param Booking $booking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approvePlotAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $booking->setStatusPlot(Booking::PLOT_APPROVED);
        $booking->setSpaceInstantBook(true);
        $em->persist($booking);
        $em->flush();
        $urlBooking = $this->generateUrl('app_user_booking_create',[
            'space'=>$booking->getSpace()->getId(),
            'booking'=>$booking->getId(),
            'step'=>1
        ],0);

        $data['url'] = $urlBooking;
        $data['space_name'] = $booking->getSpace()->getName();
        $data['host_name'] = $this->getUser()->getFirstName() .' ' .$this->getUser()->getLastName();
        $data['user_name'] = $booking->getUser()->getFirstName() .' ' .$booking->getUser()->getLastName();
        $this->get('app.email_sender')->sendEmailOfferPlot($booking->getUser()->getEmail(),$data);
        return $this->redirectToRoute('app_user_host_control_list_booking', [
        ]);
    }
    public function approveBookingAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $booking->setSpaceInstantBook(true);
        $em->persist($booking);
        $em->flush();
        $urlBooking = $this->generateUrl('app_user_booking_create',[
            'space'=>$booking->getSpace()->getId(),
            'booking'=>$booking->getId(),
            'step'=>2
        ],0);

        $data['url'] = $urlBooking;
        $data['space_name'] = $booking->getSpace()->getName();
        $data['host_name'] = $this->getUser()->getFirstName() .' ' .$this->getUser()->getLastName();
        $data['user_name'] = $booking->getUser()->getFirstName() .' ' .$booking->getUser()->getLastName();
        $this->get('app.email_sender')->sendEmailApproveBooking($booking->getUser()->getEmail(),$data);
        return $this->redirectToRoute('app_user_host_control_list_booking', [
        ]);
    }
    public function rejectPlotAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();
        $booking->setStatusPlot(Booking::PLOT_REJECTED);
        $booking->setStatus(Booking::STATUS_CANCELLED);
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
            $message->setSpace($space);
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
