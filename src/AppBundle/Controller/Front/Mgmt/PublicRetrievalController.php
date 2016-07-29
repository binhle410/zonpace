<?php

namespace AppBundle\Controller\Front\Mgmt;

use AppBundle\Entity\Core\User;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PublicRetrievalController extends ControllerService
{

    public function searchSpacesAction(Request $request)
    {
        if($request->get('lat') === null || $request->get('lat') ==='' || $request->get('lng') === null || $request->get('lng') ===''){
            return $this->redirectToRoute('app_default');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');

        $featureCategories = $entityManager->getRepository('ApplicationSonataClassificationBundle:Category')->findAll();
        $radius = $this->getParameter('search_radius');

        $qb = $spaceRepo->searchSpaces($request->query->all(),$radius);
        $spaces = $this->pagingBuilder($request, $qb);
        return $this->render('AppBundle:Front:search-spaces.html.twig',[
            'spaces'=>$spaces,
            'featureCategories'=>$featureCategories
        ]);
    }

    /**
     * Will use slug later
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hostProfileAction(Request $request,User $user){

        $em = $this->getDoctrine()->getManager();
        $spaceRepo = $em->getRepository('AppBundle:Space\Space');
        $numberActiveListing = $spaceRepo->getNumberActiveListing($user);

        $listingsQb = $spaceRepo->findMySpaces($user,['status-space'=>'enabled']);
        $listings= $this->pagingBuilder($request,$listingsQb);

        return $this->render('AppBundle:Front:host-profile.html.twig',[
            'user'=>$user,
            'numberActiveListing'=>$numberActiveListing,
            'listings'=>$listings
        ]);
    }
}
