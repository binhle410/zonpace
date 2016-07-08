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


   

}
