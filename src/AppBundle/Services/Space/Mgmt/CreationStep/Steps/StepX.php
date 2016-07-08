<?php

namespace AppBundle\Services\Appraisal\Mgmt\CreationStep\Steps;

use AppBundle\Services\Appraisal\Mgmt\CreationStep\AbstractStep;

class StepX extends AbstractStep
{

    public function process()
    {
        $appraisal = $this->appraisal;
        $company = $this->company;
        $request = $this->getRequest();
        $this->checkPermissionWorkflowAppraisal($appraisal, array('EM', 'RO', 'AO'));
        return $this->render('AppBundle:Appraisal/Steps:stepX.html.twig', array(
                    'company' => $company,
                    'appraisal' => $appraisal,
                    'type' => $this->getTypeUserAppraisal($appraisal),
                    'nomination' => $appraisal->getNomination(),
        ));
    }

}
