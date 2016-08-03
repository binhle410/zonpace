<?php

namespace AppBundle\Controller\User\Space\Mgmt;

use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;

class SpaceRetrievalController extends ControllerService
{

    public function listAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');
        $qb = $spaceRepo->findMySpaces($this->getUser(),$request->query->all());
        $spaces = $this->pagingBuilder($request, $qb);

        return $this->render('AppBundle:User/Space:list.html.twig',['spaces'=>$spaces]);
    }
    public function viewAction(Request $request,Space $space)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $bookings = $entityManager->getRepository('AppBundle:Booking\Booking')->findHostBooking($this->getUser(),$request->query->all())->getQuery()->getResult();
        $dataBookings =  $this->generateDataBookings($bookings);
        return $this->render('AppBundle:User/Space:view.html.twig',[
            'space'=>$space,
            'dataBookings'=>$dataBookings
        ]);
    }

}
