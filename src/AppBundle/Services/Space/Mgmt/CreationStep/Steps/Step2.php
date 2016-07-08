<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;

class Step2 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();

        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO'));

        if ($request->getMethod() == 'POST' && $appraisal->getStep() == 2) {
            $typeSubmit = $request->get('submit');
            $entityManager = $this->getDoctrine()->getManager();
            //update step,status
            switch ($typeSubmit) {
                case 'Submit Targets for Review';
                    $appraisal->setStep(3);
                    $appraisal->setStatus($this->getStatusByCode('appraisal_status_review_new_target'));
                    $entityManager->persist($appraisal);
                    $entityManager->flush();
                    //send mail to RO
                    $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 2);
                    //redirec to step 3
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 3));
                case 'Take me to the next step without submitting new targets';
                    $appraisal->setStep(4);
                    $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_employee_ratings'));
                    $entityManager->persist($appraisal);
                    $entityManager->flush();
                    //redirect to step 4
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 4));
            }
        }
        return $this->render('AppBundle:Appraisal/Steps:step2.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'step' => $appraisal->getStep(),
                    'type' => $this->getTypeUserAppraisal($appraisal),
        ));
    }

}
