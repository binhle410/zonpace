<?php


namespace AppBundle\Controller\Front\Mgmt;


use AppBundle\Entity\Core\User;
use AppBundle\Entity\Core\UserMessage;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PublicManipulationController extends ControllerService
{

    public function contactHostAction(Request $request,User $user){

        if($request->isMethod('post')){
            $em = $this->getDoctrine()->getManager();
            $message = $request->get('message');
            $userMassage = new UserMessage();
            $userMassage->setMessage($message);
            $userMassage->setUser($user);
            $em->persist($userMassage);
            $em->flush();
            return $this->redirectToRoute('app_front_host_profile',['user'=>$user->getId()]);
        }


    }

    public function contactAction(Request $request)
    {

        $name = $request->get('name');
        $email = $request->get('email');
        $message = $request->get('message');
        if ($name != '' && $email != '' && $message != '') {
            $data = array('name' => $name, 'email' => $email, 'message' => $message);
            $this->get('app.email_sender')->sendEmailContact($data);
        }
        return $this->redirectToRoute('app_index');
    }
}
