<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;
use AppBundle\Entity\Appraisal\Comment;
use AppBundle\Form\Appraisal\CommentType;
use AppBundle\Form\Appraisal\OverallReviewType;

class Step7 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $this->checkPermissionWorkflowAppraisal($appraisal, array('RO'));
        $entityManager = $this->getDoctrine()->getManager();
        $overallReview = $appraisal->getOverallReview();
        $form = $this->createForm(new OverallReviewType(), $overallReview, array('appraisal' => $appraisal));
        if ($form->handleRequest($request)->isSubmitted()) {
            $typeSubmit = $request->get('submit');
            if ($form->isValid()) {
                $status = ($request->get('submit') == 'Submit' ? $this->getParameter('appraisal_status_published') : $this->getParameter('appraisal_status_draft'));
                $overallReview->setStatus($status);
                $entityManager->persist($overallReview);
                $entityManager->flush();
                if ($typeSubmit != 'Draft') {
                    $appraisal->setStep(8);
                    $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_RO_recommendation'));
                    $entityManager->persist($appraisal);
                    $entityManager->flush();
                    //send mail to em
                    $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 7);
                    return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 8));
                }
            }
        }


        return $this->render('AppBundle:Appraisal/Steps:step7.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'step' => $appraisal->getStep(),
                    'type' => $this->getTypeUserAppraisal($appraisal),
                    'form' => $form->createView(),
        ));
    }

}
