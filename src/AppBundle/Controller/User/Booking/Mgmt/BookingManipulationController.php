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
            $booking->setUser($this->getUser());
            $booking->setSpace($space);
            $booking->setIsPlot(true);
            if ($type == 'user') {
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
                return $this->redirectToRoute('app_user_host_control_list_booking', [
                ]);
            }
        }
        return $this->render('AppBundle:User/Booking/Steps:plot-space.html.twig', array(
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


}
