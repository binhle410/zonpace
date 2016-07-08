<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep\Steps;

use AppBundle\Services\Space\Mgmt\CreationStep\Step;

class Step1 extends Step
{

    public function process()
    {
//        $appraisal = $this->appraisal;
//        $company = $this->company;
//        $request = $this->getRequest();
//
//        //check permission
//        $this->checkPermissionWorkflowAppraisal($appraisal, array('RO'));
//        if ($request->getMethod() == 'POST' && $appraisal->getStep() == 1) {
//            //1.update step,status
//            $entityManager = $this->getDoctrine()->getManager();
//            $appraisal->setStep(2);
//            $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_employee_input'));
//            $entityManager->persist($appraisal);
//            $entityManager->flush();
//
//            //2.send mail 1 invite
//            $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 1);
//            //3.redirect to step 2
//            return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 2));
//        }
//        return $this->render('AppBundle:Appraisal/Steps:step1.html.twig', array(
//                    'company' => $company,
//                    'appraisal' => $appraisal,
//                    'step' => $appraisal->getStep(),
//        ));
    }

}
