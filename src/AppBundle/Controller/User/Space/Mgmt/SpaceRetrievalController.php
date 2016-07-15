<?php

namespace AppBundle\Controller\User\Space\Mgmt;

use AppBundle\Services\Core\ControllerService;
use Symfony\Component\HttpFoundation\Request;

class SpaceRetrievalController extends ControllerService
{

    public function listAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $spaceRepo = $entityManager->getRepository('AppBundle:Space\Space');
        $qb = $spaceRepo->findMySpaces($this->getUser());
        $spaces = $this->pagingBuilder($request, $qb);

        return $this->render('AppBundle:User/Space:list.html.twig',['spaces'=>$spaces]);
    }

}
