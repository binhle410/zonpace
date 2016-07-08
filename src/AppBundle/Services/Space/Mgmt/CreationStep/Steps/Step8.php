<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;
use AppBundle\Form\Appraisal\NominationType;

class Step8 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $this->checkPermissionWorkflowAppraisal($appraisal, array('RO'));
        $entityManager = $this->getDoctrine()->getManager();
        $nomination = $appraisal->getNomination();
        $form = $this->createForm(new NominationType(), $nomination, array('type' => 'RO'));
        if ($form->handleRequest($request)->isSubmitted()) {
            if ($form->isValid()) {
                $nomination->setDateReviewerSubmit(new \DateTime());
                $entityManager->persist($nomination);

                $appraisal->setStep(9);
                $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_AO_approval'));
                $entityManager->persist($appraisal);
                $entityManager->flush();
                if ($this->isAOEqualRO($appraisal)) {
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 9));
                } else {
                    //send mail to AO
                    $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 8);
                }
            }
        }


        return $this->render('AppBundle:Appraisal/Steps:step8.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'step' => $appraisal->getStep(),
                    'type' => $this->getTypeUserAppraisal($appraisal),
                    'form' => $form->createView(),
                    'nomination' => $nomination,
        ));
    }

}
