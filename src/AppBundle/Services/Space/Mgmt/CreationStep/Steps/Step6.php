<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;
use AppBundle\Entity\Appraisal\Comment;
use AppBundle\Form\Appraisal\CommentType;

class Step6 extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $page = $request->get('page');
        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO'));
        $entityManager = $this->getDoctrine()->getManager();
        $typeSubmit = '';
        $employee = $appraisal->getEmployee();

        if(count($employee->getComments())){
            $comment = $employee->getComments()[0];
        }else{
            $status = $this->getParameter('appraisal_status_draft');
            $comment = new Comment();
            $comment->setText('');
            $comment->setAppraisal($appraisal);
            $comment->setEmployee($employee);
            $comment->setStatus($status);
            $entityManager->persist($comment);
        }

        $formComment = $this->createForm(new CommentType(), $comment);
        if ($formComment->handleRequest($request)->isSubmitted()) {
            if ($formComment->isValid()) {
                $typeSubmit = $request->get('submit');
                $status = ($typeSubmit == 'Submit' ? $this->getParameter('appraisal_status_published') : $this->getParameter('appraisal_status_draft'));
                $comment->setAppraisal($appraisal);
                $comment->setEmployee($employee);
                $comment->setStatus($status);
                $entityManager->persist($comment);
                $entityManager->flush();
            }
        }
        //proceed by step
        if ($typeSubmit == 'Submit') {
            $appraisal->setStep(7);
            $appraisal->setStatus($this->getStatusByCode('appraisal_status_awaiting_RO_overall_review'));
            $entityManager->persist($appraisal);
            $entityManager->flush();
            //send mail to RO
            $this->container->get('app.email_sender')->sendMailAppraisal($company, $appraisal, 6);

        }

        return $this->render('AppBundle:Appraisal/Steps:step6.html.twig', array(
            'company' => $company,
            'appraisal' => $appraisal,
            'step' => $appraisal->getStep(),
            'type' => $this->getTypeUserAppraisal($appraisal),
            'page' => $page,
            'form' => $formComment->createView()
        ));
    }

}
