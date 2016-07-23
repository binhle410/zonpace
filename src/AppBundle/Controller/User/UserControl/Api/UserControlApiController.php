<?php


namespace AppBundle\Controller\User\UserControl\Api;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Form\SpaceBookingReviewType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class UserControlApiController extends ControllerService
{

    public function sendVerifiedCodeAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $phone = $request->get('phone');
            $verifiedCode = rand(100000,999999);
            $user = $this->getUser();
            $user->setVerifiedCodePhone($verifiedCode);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
        $twilio = $this->get('twilio.api');

        $message = $twilio->account->messages->sendMessage(
            '+12565154273',
            $phone,
            $verifiedCode
        );

        //get an instance of \Service_Twilio
//        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        return new Response($message->sid);
        }
    }

}
