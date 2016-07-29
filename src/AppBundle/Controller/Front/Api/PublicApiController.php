<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Core\User;

class PublicApiController extends ControllerService
{

    public function getNearByListingAction(Request $request){
        if($request->isXmlHttpRequest()){
            $entityManager = $this->getDoctrine()->getManager();
            $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');
            $nearByLocations = $request->get('nearByLocations');
            $data = [];
            foreach ($nearByLocations as $nearByLocation){
                $radius = $this->getParameter('search_radius');
                $numberListing = $spaceRepo->getNumberListingNearbySpaces($nearByLocation,$radius);
                $data[] = ['name'=>$nearByLocation['name'],'numberListing'=>$numberListing];
            }
            return new JsonResponse(['status'=>true,'data'=>$data]);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSpaceAction(Request $request,User $user){

        $em = $this->getDoctrine()->getManager();
        $spaceRepo = $em->getRepository('AppBundle:Space\Space');

        $listingsQb = $spaceRepo->findMySpaces($user,['status-space'=>'enabled']);
        $listings= $this->pagingBuilder($request,$listingsQb);


        $html = $this->renderView('AppBundle:Front:_host-profile-list-space.html.twig',
            [
                'user'=>$user,
                'listings'=>$listings
            ]
        );
        return new JsonResponse(['status'=>true,'html'=>$html]);
    }
    /**
     * of host(have many space) , or of a space
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listReviewAction(Request $request,User $user = null,Space $space = null){


        $em = $this->getDoctrine()->getManager();
        $bookingRepo = $em->getRepository('AppBundle:Booking\Booking');

        if($user != null){
            $reviewsQb = $bookingRepo->findHostBooking($user,['is-review'=>true]);
            $reviews = $this->pagingBuilder($request,$reviewsQb);
        }elseif($space != null){
            $reviewsQb = $bookingRepo->findSpaceBooking($space);
            $reviews = $this->pagingBuilder($request,$reviewsQb);
        }

        $html = $this->renderView('AppBundle:Front:_list-review.html.twig',
            [
                'user'=>$user,
                'reviews'=>$reviews,
                'space'=>$space
            ]
        );
        return new JsonResponse(['status'=>true,'html'=>$html]);
    }
}
