<?php

namespace AppBundle\Controller\User\Booking\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
use AppBundle\Form\PlotSpaceType;
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
    public function plotSpaceAction(Request $request,Space $space,Booking $booking=null)
    {
        if($booking == null){
            $booking = new Booking();
        }
        $form = $this->createForm(PlotSpaceType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $booking->setUser($this->getUser());
            $booking->setSpace($space);
            $booking->setIsPlot(true);
            $booking->setStatusPlot(Booking::PLOT_PENDING);
            $em->persist($booking);
            $em->flush();

        return $this->redirectToRoute('app_user_booking_create', [
            'space' => $space->getId(),
            'step' => 0
        ]);
        }
        return $this->render('AppBundle:User/Booking/Steps:plot-space.html.twig', array(
            'booking' => $booking,
            'space' => $space,
            'form' => $form->createView()
        ));
    }
    

}
