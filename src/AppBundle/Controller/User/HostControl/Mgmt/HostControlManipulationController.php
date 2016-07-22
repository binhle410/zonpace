<?php


namespace AppBundle\Controller\User\HostControl\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Form\SpaceBookingReviewType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

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

}
