<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;

class StepZ extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $this->checkPermissionWorkflowAppraisal($appraisal, array('AO'));
        return $this->render('AppBundle:Appraisal/Steps:stepZ.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'type' => $this->getTypeUserAppraisal($appraisal),
        ));
    }

}
