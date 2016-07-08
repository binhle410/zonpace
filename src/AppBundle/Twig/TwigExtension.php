<?php

namespace AppBundle\Twig;


class TwigExtension extends \Twig_Extension
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }




    public function getFunctions()
    {
        return array(
            'getParameter' => new \Twig_Function_Method($this, 'getParameter', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
