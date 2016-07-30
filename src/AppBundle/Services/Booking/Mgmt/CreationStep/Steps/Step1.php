<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;

use AppBundle\Form\BookingType;
use AppBundle\Form\SpaceType;
use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use Application\Sonata\MediaBundle\Entity\Media;

class Step1 extends Step
{

    public function process()
    {
        $space = $this->space;
        $booking = $this->booking;
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $featureCategories = $em->getRepository('ApplicationSonataClassificationBundle:Category')->findAll();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');
        $spaceRepo = $em->getRepository('AppBundle:Space\Space');
        $numberReviewSpace = $bookingRepo->getTotalReviewSpace($space);
        $reviewsQb = $bookingRepo->findSpaceBooking($space);
        $reviews = $this->pagingBuilder($request,$reviewsQb);

        $numberActiveListingHost = $spaceRepo->getNumberActiveListing($space->getUser());
        $numberReviewHost = $bookingRepo->getTotalReviewHost($space->getUser());

        $form = $this->createForm(BookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $booking->setSpace($space);
            $em->persist($booking);
            $em->flush();
            return $this->redirectToRoute('app_user_booking_create',[
                'space' => $space->getId(),
                'booking' => $booking->getId(),
                'step' => 2
            ]);
        }

        return $this->render('AppBundle:User/Booking/Steps:detail.html.twig', array(
            'space'=>$space,
            'featureCategories'=>$featureCategories,
            'numberReviewSpace'=>$numberReviewSpace,
            'reviews'=>$reviews,
            'numberActiveListingHost'=>$numberActiveListingHost,
            'numberReviewHost'=>$numberReviewHost,
            'form'=>$form->createView()
        ));
    }

}
