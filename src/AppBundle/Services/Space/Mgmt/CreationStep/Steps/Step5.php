<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;
use AppBundle\Entity\Appraisal\Comment;
use AppBundle\Form\Appraisal\CommentType;

class Step5 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $page = $request->get('page');
        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO'));
        $em = $this->getDoctrine()->getManager();
        $typeSubmit = '';
        //comment
        $reviewer = $appraisal->getReviewers()[0];
        if(count($reviewer->getComments())){
            $comment = $reviewer->getComments()[0];
        }else{
            $status = $this->getParameter('appraisal_status_draft');
            $comment = new Comment();
            $comment->setText('');
            $comment->setAppraisal($appraisal);
            $comment->setReviewer($reviewer);
            $comment->setStatus($status);
            $em->persist($comment);
            $em->flush();
        }
        $formComment = $this->createForm(new CommentType(), $comment);
        if ($formComment->handleRequest($request)->isSubmitted()) {
            $typeSubmit = $request->get('submit');
            if ($formComment->isValid()) {
                $status = ($typeSubmit == 'Submit' ? $this->getParameter('appraisal_status_published') : $this->getParameter('appraisal_status_draft'));
                $comment->setAppraisal($appraisal);
                $comment->setReviewer($reviewer);
                $comment->setStatus($status);
                $em->persist($comment);
                $em->flush();
            }
        }
        //rating
        if ($request->isMethod('post')) {
            $typeSubmit = $request->get('submit');
            $data = $request->request->all();
            $statusRating = ($data['submit'] == 'Submit' ? $this->getParameter('appraisal_status_published') : $this->getParameter('appraisal_status_draft'));
            if (isset($data['reviewer'])) {
                foreach ($data['reviewer'] as $id => $value) {
                    $performanceRating = $em->getRepository('AppBundle\Entity\Appraisal\PerformanceRating')->find($id);
                    $performanceRating->setRoScore($value);
                    $performanceRating->setStatusRatingReviewer($statusRating);
                    $em->persist($performanceRating);
                }
            }
            $em->flush();
        }
        //proceed by step
        if ($typeSubmit == 'Submit') {
            if ($page == 1) {
                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 5, 'page' => 2));
            } elseif ($page == 2) {
                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 5, 'page' => 3));
            } else {
                $appraisal->setStep(6);
                $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_EM_overall_review'));
                $em->persist($appraisal);
                $em->flush();
                //send mail to em
                $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 5);
                return $this->redirectToRoute('app_admin_appraisal_workflow_steps', array('company' => $company->getId(), 'appraisal' => $appraisal->getId(), 'step' => 6));
            }
        }
        return $this->render('AppBundle:Appraisal/Steps:step5.html.twig', array(
            'company' => $company,
            'appraisal' => $appraisal,
            'step' => $appraisal->getStep(),
            'type' => $this->getTypeUserAppraisal($appraisal),
            'page' => $page,
            'form' => $formComment->createView(),
        ));
    }

}
