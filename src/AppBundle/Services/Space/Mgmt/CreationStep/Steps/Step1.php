<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep\Steps;

use AppBundle\Form\SpaceType;
use AppBundle\Services\Space\Mgmt\CreationStep\Step;

class Step1 extends Step
{

    public function process()
    {
        $form = $this->createForm(SpaceType::class,$this->space,['step'=>1]);
        $form->handleRequest($this->getRequest());
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $this->space->setUser($this->getUser());    
            $entityManager->persist($this->space);
            $entityManager->flush();
            return $this->redirectToRoute('app_space_create',['space' => $this->space->getId(),'step' => 2]);
        }
        return $this->render('AppBundle:Space/Steps:step1.html.twig', array(
            'space'=>$this->space,
             'form' => $form->createView(),
        ));
    }

}
