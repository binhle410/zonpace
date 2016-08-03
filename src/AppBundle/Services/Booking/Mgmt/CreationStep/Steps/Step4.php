<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;


use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use AppBundle\Form\SpaceType;
use Doctrine\Common\Util\Debug;
use AppBundle\Entity\Booking\Booking;

class Step4 extends Step
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


        return $this->render('AppBundle:User/Booking/Steps:step4.html.twig', array(
            'space'=>$space,
            'booking'=>$booking,
            'featureCategories'=>$featureCategories,
            'numberReviewSpace'=>$numberReviewSpace,
            'reviews'=>$reviews,
            'numberActiveListingHost'=>$numberActiveListingHost,
            'numberReviewHost'=>$numberReviewHost,
        ));
    }

}
