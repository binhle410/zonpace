<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;


use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use AppBundle\Form\SpaceType;
use Doctrine\Common\Util\Debug;
use AppBundle\Entity\Booking\Booking;

class Step4 extends Step
{

    public function process()
    {
        $space = $this->space;
        $booking = $this->booking;
        $request = $this->getRequest();




        return $this->render('AppBundle:User/Booking/Steps:step4.html.twig', array(

        ));
    }

}
