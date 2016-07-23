<?php


namespace AppBundle\Controller\User\UserControl\Mgmt;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Form\SpaceBookingReviewType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\UserSettingType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;

class UserControlManipulationController extends ControllerService
{

    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $oldPhone = $user->getPhone();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($oldPhone != $user->getPhone()){
                $user->setIsVerifiedPhone(false);
            }
            $user->setIsCompletedProfile(true);
            $em->persist($user);
            $em->flush();
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            echo '<pre>';
            \Doctrine\Common\Util\Debug::dump($this->get('app.form_serializer')->serializeFormErrors($form, true, true));
        }
        return $this->render('AppBundle:User/UserControl:profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    public function reviewSpaceAction(Request $request,Booking $booking)
    {
        $form = $this->createForm(SpaceBookingReviewType::class,$booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setIsReview(true);
            $em->persist($booking);
            $em->flush();
            return $this->redirectToRoute('app_user_user_control_list_booking');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            echo '<pre>';
            \Doctrine\Common\Util\Debug::dump($this->get('app.form_serializer')->serializeFormErrors($form, true, true));
        }
    }

    public function settingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $oldPhone = $user->getPhone();
        $userSetting = $user->getUserSetting();

        $form1 = $this->createForm(UserSettingType::class, $userSetting);
        $form1->get('phone')->setData($user->getPhone());
        $form2 = $this->createForm(UserPasswordType::class,$user);

        if ($request->getMethod() === 'POST') {
            $data = $request->request->all();
            if (isset($data['app_core_user_setting'])) {
                $form1->handleRequest($request);
                if ($form1->isSubmitted() && $form1->isValid()) {
                    $em->persist($userSetting);
                    if($oldPhone != $form1->get('phone')->getData()){
                        $user->setIsVerifiedPhone(false);
                    }
                    $user->setPhone($form1->get('phone')->getData());
                    $em->persist($user);
                    $em->flush();
                }
            }
            if (isset($data['app_core_user_password'])) {
                $currentPassword = $user->getPassword();
                $encoder = $this->get('security.password_encoder');
                $userManager = $this->get('fos_user.user_manager');
                $form2->handleRequest($request);
                if ($form2->isSubmitted() && $form2->isValid()) {
//                    $s = $form2->get('currentPassword')->getData();
//                    $a = $encoder->encodePassword($user,$s);
//                    if ($currentPassword == $a) {
                        $encoded = $encoder->encodePassword($user, $user->getPassword());
                        $user->setPassword($encoded);
                        $userManager->updateUser($user);
                        $this->addFlash('message', 'Update account successfully.');
//                    }
                }
            }
        }


        return $this->render('AppBundle:User/UserControl:setting.html.twig', [
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    public function verificationAction(Request $request)
    {
        return $this->render('AppBundle:User/UserControl:verification.html.twig', [
        ]);
    }

}
