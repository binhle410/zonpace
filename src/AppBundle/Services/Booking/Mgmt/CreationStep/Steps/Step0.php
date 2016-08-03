<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;

use AppBundle\Form\BookingType;
use AppBundle\Form\SpaceType;
use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use Application\Sonata\MediaBundle\Entity\Media;

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
            $available = $this->checkAvailableBooking($space, $booking->getDateFrom()->format('Y-m-d'), $booking->getDateTo()->format('Y-m-d'));
            if ($available) {
                $em = $this->getDoctrine()->getManager();
                $price = $this->getPriceBooking($booking->getDateFrom()->format('Y-m-d'),$booking->getDateTo()->format('Y-m-d'),$booking->getSpace()->getPrice()->getDaily(),1);
                $price= round($price,1);
                $booking->setTotalPrice($price);
                $booking->setSpace($space);
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
