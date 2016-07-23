<?php


namespace AppBundle\Controller\User\UserControl\Api;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Form\SpaceBookingReviewType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class UserControlApiController extends ControllerService
{

    public function sendVerifiedCodeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $phoneFrom = $this->getParameter('vresh_twilio_phone_from');
            $phoneTo = $request->get('phone');
            $verifiedCode = rand(100000, 999999);
            $user = $this->getUser();
            $user->setVerifiedCodePhone($verifiedCode);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
            $twilio = $this->get('twilio.api');

            $message = $twilio->account->messages->sendMessage(
                $phoneFrom,
                $phoneTo,
                $verifiedCode
            );

            //get an instance of \Service_Twilio
//        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

            return new JsonResponse($message->sid);
        }
    }

    public function verifyCodeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $code = $request->get('code');
            $user = $this->getUser();
            if ($code == $user->getVerifiedCodePhone()) {
                $user->setIsVerifiedPhone(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $result = ['status' => true, 'Verify successfully.'];
            } else {
                $result = ['status' => false, 'Verified code incorrect.'];
            }
            return new JsonResponse($result);

        }
    }

}
