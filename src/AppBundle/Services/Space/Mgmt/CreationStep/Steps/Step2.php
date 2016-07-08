<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep\Steps;


use AppBundle\Services\Space\Mgmt\CreationStep\Step;
use AppBundle\Form\SpaceType;

class Step2 extends Step
{

    public function process()
    {
        $form = $this->createForm(SpaceType::class,$this->space);
        $form->handleRequest($this->getRequest());
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($this->space);
            $entityManager->flush();
            return $this->redirectToRoute('app_space_create',['space' => $this->space->getId(),'step' => 3]);
        }
        return $this->render('AppBundle:Space/Steps:step2.html.twig', array(
            'space'=>$this->space,
            'form' => $form->createView(),
        ));
    }

}
