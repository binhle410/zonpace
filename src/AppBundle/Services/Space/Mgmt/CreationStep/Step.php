<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep;


use AppBundle\Entity\Space\Space;
use AppBundle\Services\Core\ControllerService;

abstract class Step extends ControllerService implements StepInterface
{

    protected $space;

    function __construct(Space $space)
    {
        $this->space = $space;
    }

}
