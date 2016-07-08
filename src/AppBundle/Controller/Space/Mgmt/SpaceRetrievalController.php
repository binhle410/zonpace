<?php

namespace AppBundle\Controller\Appraisal\Mgmt;

use AppBundle\Services\Appraisal\ControllerAppraisalService;
use AppBundle\Entity\Core\Company;
use AppBundle\Entity\Core\Department;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Appraisal\Appraisal;

class AppraisalRetrievalController extends ControllerAppraisalService
{

    /**
     * Type = 1 : My Appraisals
     * Type = 2 : Manage Appraisal
     * Type = 3 : Your Appraisees
     * @param Company $company
     * @param Department $type
     *  @return
     */
    public function listAction(Request $request, Company $company, $type)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->denyAccessUnlessGranted('view', $company, 'Unauthorized access!');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $appraisalRepo = $entityManager->getRepository('AppBundle\Entity\Appraisal\Appraisal');
        switch ($type) {
            case $this->getParameter('appraisal_my_appraisal'):
                $queryBuilder = $appraisalRepo->findMyAppraisal($this->getUser());
                break;
            case $this->getParameter('appraisal_manage_appraisal'):
                $queryBuilder = $appraisalRepo->findManageAppraisal($company);
                break;
            case $this->getParameter('appraisal_my_appraisees'):
                $queryBuilder = $appraisalRepo->findMyAppraisees($this->getUser());
                break;
        }
        $appraisals = $this->pagingBuilder($request, $queryBuilder);


        return $this->render('AppBundle:Appraisal:list.html.twig', array(
                    'company' => $company,
                    'appraisals' => $appraisals,
                    'type' => $type
        ));
    }

    public function loadCommentAction(Request $request, Company $company, Appraisal $appraisal, $type, $typeComment, $allowEdit)
    {
        $em = $this->getDoctrine()->getManager();
        $limit = $this->container->getParameter('pagination_limit');
        $offset = $request->get('offset');
        $step = $appraisal->getStep();
        $statusPublish = $this->getParameter('appraisal_status_published');
        switch ($type) {
            case 'RO':
                $reviewer = $appraisal->getReviewers()[0];
                if ($step == 5) {
                    $comments = $em->getRepository('AppBundle\Entity\Appraisal\Comment')->findBy(
                            array('reviewer' => $reviewer, 'appraisal' => $appraisal), array('createdDate' => 'desc'), $limit, $offset
                    );
                } else {
                    $comments = $em->getRepository('AppBundle\Entity\Appraisal\Comment')->findBy(
                            array('reviewer' => $reviewer, 'appraisal' => $appraisal, 'status' => $statusPublish), array('createdDate' => 'desc'), $limit, $offset
                    );
                }
                break;
            case 'EM':
                $employee = $appraisal->getEmployee();
                if ($step == 6) {
                    $comments = $em->getRepository('AppBundle\Entity\Appraisal\Comment')->findBy(
                            array('employee' => $employee, 'appraisal' => $appraisal), array('createdDate' => 'desc'), $limit, $offset
                    );
                } else {
                    $comments = $em->getRepository('AppBundle\Entity\Appraisal\Comment')->findBy(
                            array('employee' => $employee, 'appraisal' => $appraisal, 'status' => $statusPublish), array('createdDate' => 'desc'), $limit, $offset
                    );
                }
                break;
        }
        return $this->render('AppBundle:Appraisal:__comment.html.twig', array(
                    'company' => $company,
                    'type' => $type,
                    'comments' => $comments,
                    'offset' => $limit,
                    'appraisal' => $appraisal,
                    'typeComment' => $typeComment,
                    'allowEdit' => $allowEdit
        ));
    }

}
