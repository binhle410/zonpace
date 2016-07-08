<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;
use AppBundle\Form\Appraisal\NominationType;

class Step9 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $this->checkPermissionWorkflowAppraisal($appraisal, array('AO'));
        $entityManager = $this->getDoctrine()->getManager();
        $nomination = $appraisal->getNomination();
        $form = $this->createForm(new NominationType(), $nomination, array('type' => 'AO'));
        if ($form->handleRequest($request)->isSubmitted()) {
            if ($form->isValid()) {
                $nomination->setDateApproverSubmit(new \DateTime());
                $entityManager->persist($nomination);

                $appraisal->setStatus($this->getStatusByCode('appraisal_status_completed'));
                $entityManager->persist($appraisal);
                $entityManager->flush();
                //send mail to RO
                $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 9);

                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 'x'));
            }
        }


        return $this->render('AppBundle:Appraisal/Steps:step9.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'step' => $appraisal->getStep(),
                    'type' => $this->getTypeUserAppraisal($appraisal),
                    'form' => $form->createView(),
                    'nomination' => $nomination,
        ));
    }

}
