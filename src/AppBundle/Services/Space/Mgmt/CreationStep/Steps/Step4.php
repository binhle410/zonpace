<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;

class Step4 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $page = $request->get('page');
        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO'));
        $typeSubmit = '';
        if ($request->isMethod('post')) {
            $em = $this->getDoctrine()->getManager();
            $typeSubmit = $request->get('submit');
            $data = $request->request->all();
            $statusRating = ($data['submit'] == 'Submit' ? $this->getParameter('appraisal_status_published') : $this->getParameter('appraisal_status_draft'));
            if (isset($data['self'])) {
                foreach ($data['self'] as $id => $value) {
                    $performanceRating = $em->getRepository('AppBundle\Entity\Appraisal\PerformanceRating')->find($id);
                    $performanceRating->setSelfScore($value);
                    $performanceRating->setStatusRatingEmployee($statusRating);
                    $em->persist($performanceRating);
                }
            }
            $em->flush();
        }
        //proceed by step
        if ($typeSubmit == 'Submit') {
            if ($page == 1) {
                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 4, 'page' => 2));
            } else {
                $appraisal->setStep(5);
                $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_RO_ratings'));
                $em->persist($appraisal);
                $em->flush();
                //send mail to RO
                $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 4);
                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 5));
            }
        }
        return $this->render('AppBundle:Appraisal/Steps:step4.html.twig', array(
            'company' => $company,
            'appraisal' => $appraisal,
            'step' => $appraisal->getStep(),
            'type' => $this->getTypeUserAppraisal($appraisal),
            'page' => $page,
        ));
    }

}
