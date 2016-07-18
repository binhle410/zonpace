<?php

namespace AppBundle\Controller;

use AppBundle\Services\Core\ControllerService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends ControllerService
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig', [
        ]);
    }
    public function searchSpacesAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');
        $qb = $spaceRepo->searchSpaces($request->query->all());
        $spaces = $this->pagingBuilder($request, $qb);

        return $this->render('AppBundle:Default:search-spaces.html.twig',['spaces'=>$spaces]);
    }
}
