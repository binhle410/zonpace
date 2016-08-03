<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep\Steps;


use AppBundle\Services\Booking\Mgmt\CreationStep\Step;
use AppBundle\Form\SpaceType;
use Doctrine\Common\Util\Debug;

class Step2 extends Step
{

    public function process()
    {
        $space = $this->space;
        $booking = $this->booking;
        $request = $this->getRequest();
        //booking
            $stripe = array(
                'secret_key'      => 'sk_test_clj9PCMa3jidJqgOTFl67d0n',
                'publishable_key' => 'pk_test_qBL4eoPC9zHxzA1kCXjm7kNZ'
            );



        return $this->render('AppBundle:User/Booking/Steps:step2.html.twig', array(
            'space'=>$space,
            'booking'=>$booking,
            'publishableKey'=>$stripe['publishable_key'],
        ));
    }

}
