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

    public function contactAction(Request $request,$url)
    {

        $url = urldecode($url);
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');

        $title = $request->get('title');
        $message = $request->get('message');
        if ($firstName != '' && $lastName != '' && $title != '' && $message != '') {
            $data = array('name_user' => $firstName.' '.$lastName , 'title' => $title, 'message' => $message);
            $this->get('app.email_sender')->sendEmailContact($data);
            return $this->redirect($url);
        }
        return $this->render('AppBundle:Front:contact.html.twig', array(
            'url'=>$url,
        ));
    }
}
