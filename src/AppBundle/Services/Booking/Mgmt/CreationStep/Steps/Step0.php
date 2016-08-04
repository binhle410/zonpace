<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;

use AppBundle\Form\BookingType;
use AppBundle\Form\SpaceType;
use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use Application\Sonata\MediaBundle\Entity\Media;
use AppBundle\Entity\Booking\Booking;

class Step0 extends Step
{

    public function process()
    {
        $space = $this->space;
        $booking = $this->booking;
        $request = $this->getRequest();

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($booking->getBookingType() == Booking::BOOKING_TYPE_DAILY){
                $begin =$booking->getDateFrom()->format('Y-m-d');
                $end =$booking->getDateTo()->format('Y-m-d');
                $dateTo = $booking->getDateTo();
            }elseif($booking->getBookingType() == Booking::BOOKING_TYPE_WEEKLY){
                $period = $booking->getBookingPeriod();
                $dateFrom = $booking->getDateFrom();
                $begin = $dateFrom->format('Y-m-d');

                $dateTo = new \DateTime($begin);
                $dateTo = $dateTo->modify('+'.$period.' week');
                $end = $dateTo->format('Y-m-d');
            }elseif($booking->getBookingType() == Booking::BOOKING_TYPE_MONTHLY){
                $period = $booking->getBookingPeriod();
                $dateFrom = $booking->getDateFrom();
                $begin = $dateFrom->format('Y-m-d');

                $dateTo = new \DateTime($begin);
                $dateTo = $dateTo->modify('+'.$period.' month');
                $end = $dateTo->format('Y-m-d');
            }
            $available = $this->checkAvailableBooking($space, $begin, $end);
            if ($available) {
                $em = $this->getDoctrine()->getManager();
                $booking->setSpace($space);
                $booking->setDateTo($dateTo);
                $em->persist($booking);
                $price = $this->getPriceBooking($booking,$space);
                $booking->setTotalPrice($price);
                $em->persist($booking);
                $em->flush();
                return $this->redirectToRoute('app_user_booking_create', [
                    'space' => $space->getId(),
                    'booking' => $booking->getId(),
                    'step' => 1
                ]);
            }
        }

        return $this->render('AppBundle:User/Booking/Steps:step0.html.twig', array(
            'space' => $space,
            'form' => $form->createView()
        ));
    }

}
