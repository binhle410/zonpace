<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PublicApiController extends ControllerService
{

    public function getNearByListingAction(Request $request){
        if($request->isXmlHttpRequest()){
            $entityManager = $this->getDoctrine()->getManager();
            $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');
            $nearByLocations = $request->get('nearByLocations');
            $data = [];
            foreach ($nearByLocations as $nearByLocation){
                $radius = $this->getParameter('nearby_radius');
                $numberListing = $spaceRepo->getNumberListingNearbySpaces($nearByLocation,$radius);
                $data[] = ['name'=>$nearByLocation['name'],'numberListing'=>$numberListing];
            }
            return new JsonResponse(['status'=>true,'data'=>$data]);
        }
    }
}
