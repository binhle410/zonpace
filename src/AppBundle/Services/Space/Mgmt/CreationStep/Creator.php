<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep;

use AppBundle\Entity\Space\Space;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Services\Core\ControllerService;
class Creator extends ControllerService
{

    private $space;
    private static $creator;

    function __construct(Space $space, ContainerInterface $container)
    {
        $this->space = $space;
        $this->setContainer($container);
    }

    /**
     * @param Space Space
     * @param ContainerInterface $container
     * @return Creator
     */
    public static function getInstance(Space $space, ContainerInterface $container)
    {
        if (empty(Creator::$creator)) {
            Creator::$creator = new Creator($space, $container);
        }
        return Creator::$creator;
    }

    public function process($step)
    {
        $class = __NAMESPACE__ . '\\Steps\\' . 'Step' . strtoupper($step);
        $creationStep = new $class($this->space);
        $creationStep->setContainer($this->container);
        return $creationStep->process();
    }

}
