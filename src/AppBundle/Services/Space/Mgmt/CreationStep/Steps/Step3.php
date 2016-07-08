<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;

class Step3 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();

        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO'));
        if ($request->getMethod() == 'POST' && $appraisal->getStep() == 3) {
            $typeSubmit = $request->get('submit');
            $entityManager = $this->getDoctrine()->getManager();
            switch ($typeSubmit) {
                case 'Submit for review';
                    //1.update step,status
                    $entityManager = $this->getDoctrine()->getManager();
                    $appraisal->setStep(2);
                    $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_employee_input'));
                    $entityManager->persist($appraisal);
                    $entityManager->flush();
                    //2.send mail 1 invite
                    $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 10);
                    //3.redirect to step 2
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 2));
                case 'Submit to next step';
                    //update step,status
                    $appraisal->setStep(4);
                    $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_employee_ratings'));
                    $entityManager->persist($appraisal);
                    $entityManager->flush();
                    //send mail to em
                    $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 3);
                    //redirect to step 4
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 4));
            }

        }
        return $this->render('AppBundle:Appraisal/Steps:step3.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'step' => $appraisal->getStep(),
                    'type' => $this->getTypeUserAppraisal($appraisal),
        ));
    }

}
