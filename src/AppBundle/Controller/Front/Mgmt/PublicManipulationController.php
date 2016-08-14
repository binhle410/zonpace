<?php


namespace AppBundle\Controller\Front\Mgmt;


use AppBundle\Entity\Core\User;
use AppBundle\Entity\Core\UserMessage;
use AppBundle\Services\Core\ControllerService;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Core\Message;
use AppBundle\Form\InboxMessageType;

class PublicManipulationController extends ControllerService
{

    public function contactHostAction(Request $request,User $user){

        if($request->isMethod('post')){
            $em =$this->getDoctrine()->getManager();
            $message = new Message();
            $form = $this->createForm(InboxMessageType::class,$message);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $message->setMessageFrom($this->getUser());
                $message->setMessageTo($user);
                $em->persist($message);
                $em->flush();
                //notify to email and phone
                $dataTo = ['email_to'=>$user->getEmail(),'phone_to'=>$user->getPhone()];
                $data['name_user_to'] = $user->getFirstName().' '.$user->getLastName();
                $data['name_user_from'] = $this->getUser()->getFirstName().' '.$this->getUser()->getLastName();
                $data['message']=$form->get('message')->getData();
                $this->notifyInbox($dataTo,$data);
                return $this->redirectToRoute('app_front_host_profile',['user'=>$user->getId()]);
            }
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
