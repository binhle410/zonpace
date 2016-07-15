<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep\Steps;


use AppBundle\Services\Space\Mgmt\CreationStep\Step;
use AppBundle\Form\SpaceType;
use Doctrine\Common\Util\Debug;

class Step6 extends Step
{

    public function process()
    {
        $form = $this->createForm(SpaceType::class,$this->space,['dateBooking'=>$this->space->getDateBooking()]);
        if($this->getRequest()->isMethod('post')){
            return $this->redirectToRoute('app_user_space_create',['space' => $this->space->getId(),'step' => 6]);
        }
        return $this->render('AppBundle:User/Space/Steps:step6.html.twig', array(
            'space'=>$this->space,
            'form' => $form->createView(),
        ));
    }

}
