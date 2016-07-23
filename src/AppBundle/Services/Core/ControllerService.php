<?php

namespace AppBundle\Services\Core;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class ControllerService extends Controller
{

    //core---------------------------------
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    public function pagingBuilder($request, $queryBuilder)
    {
        $limit = $this->container->getParameter('pagination_limit');
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $page = $request->get('page', 1);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);
        return $pagerfanta;
    }

    public function getLocationRatingSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getLocationRatingSpace($space);
    }
    public function getCommunicationRatingSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getCommunicationRatingSpace($space);
    }
    public function getRatingSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getRatingSpace($space);
    }
    public function getTotalReviewSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getTotalReviewSpace($space);
    }
    public function getTotalEarningSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getTotalEarningSpace($space);
    }
    public function getTotalBookingSpace($space){
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking\Booking')->getTotalBookingSpace($space);
    }


   

}
