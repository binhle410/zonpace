<?php


namespace AppBundle\Controller\User\UserControl\Mgmt;

use AppBundle\Form\UserProfileType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class UserControlManipulationController extends ControllerService
{

    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }elseif($form->isSubmitted() && !$form->isValid()){
            echo '<pre>';
            \Doctrine\Common\Util\Debug::dump($this->get('app.form_serializer')->serializeFormErrors($form,true,true));
        }
        return $this->render('AppBundle:User/UserProfile:profile.html.twig', [
            'form' => $form->createView(),
            'user'=>$user,
        ]);
    }

    public function myBooking(Request $request)
    {

    }

    public function mySetting(Request $request)
    {

    }

    public function verification(Request $request)
    {

    }

}
