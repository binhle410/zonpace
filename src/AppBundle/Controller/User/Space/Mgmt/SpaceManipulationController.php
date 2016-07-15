<?php

namespace AppBundle\Controller\User\Space\Mgmt;

use AppBundle\Entity\Space\Space;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use AppBundle\Services\Space\Mgmt\CreationStep\Creator;

class SpaceManipulationController extends ControllerService
{

    public function stepAction(Request $request,$step,Space $space = null)
    {
        if(!$space){
            $space = new Space();
            $space->setUser($this->getUser());
        }
        $creator = Creator::getInstance($space, $this->container);
        if (in_array($step, array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'x'))) {
            return $creator->process($step);
        }
    }

}
