<?php

namespace AppBundle\Services\Booking\Mgmt\CreationStep;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Services\Core\ControllerService;
class Creator extends ControllerService
{

    private $space;
    private $booking;
    private static $creator;

    function __construct(Space $space,Booking $booking, ContainerInterface $container)
    {
        $this->space = $space;
        $this->booking = $booking;
        $this->setContainer($container);
    }

    /**
     * @param Space Space
     * @param ContainerInterface $container
     * @return Creator
     */
    public static function getInstance(Space $space,Booking $booking, ContainerInterface $container)
    {
        if (empty(Creator::$creator)) {
            Creator::$creator = new Creator($space,$booking, $container);
        }
        return Creator::$creator;
    }

    public function process($step)
    {
        $class = __NAMESPACE__ . '\\Steps\\' . 'Step' . strtoupper($step);
        $creationStep = new $class($this->space,$this->booking);
        $creationStep->setContainer($this->container);
        return $creationStep->process();
    }

}
