<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig', [
        ]);
    }
    public function searchSpacesAction(Request $request)
    {
        // replace this example code with whatever you need
        
        return $this->render('AppBundle:Default:search-spaces.html.twig', [
        ]);
    }
}
