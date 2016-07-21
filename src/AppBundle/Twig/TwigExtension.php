<?php

namespace AppBundle\Twig;


use Application\Sonata\MediaBundle\Entity\Media;

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


    public function getUrl(Media $media, $context = 'default', $format = 'medium')
    {
        return $this->container->get('app.media.retriever')->getPublicURL($media, $context, $format);
    }

    public function getlAphabetNameSpace($index)
    {
        $aphabet = range('A', 'Z');
        if (isset($aphabet[$index])) {
            return $aphabet[$index];
        }
        return 'N/A';
    }

    public function getTypeSpace($key)
    {
        $spaceType = [
            'VACANT_LAND' => 'Vacant land',
            'SPACE_ATTACHED_TO_PROPERTY' => 'Space attached to property',
            'EVENT_SPACE' => 'Event space'
        ];
        return $spaceType[$key];
    }
    public function getTypeSpaces()
    {
        $spaceType = [
            'VACANT_LAND' => 'Vacant land',
            'SPACE_ATTACHED_TO_PROPERTY' => 'Space attached to property',
            'EVENT_SPACE' => 'Event space'
        ];
        return $spaceType;
    }
    public function getStatusSpaces()
    {
        $spaceType = [
            0 => 'Disabled',
            1 => 'Enabled',
        ];
        return $spaceType;
    }

    public function getFunctions()
    {
        return array(
            'getParameter' => new \Twig_Function_Method($this, 'getParameter', array('is_safe' => array('html'))),
            'getUrl' => new \Twig_Function_Method($this, 'getUrl', array('is_safe' => array('html'))),
            'getlAphabetNameSpace' => new \Twig_Function_Method($this, 'getlAphabetNameSpace', array('is_safe' => array('html'))),
            'getTypeSpace' => new \Twig_Function_Method($this, 'getTypeSpace', array('is_safe' => array('html'))),
            'getTypeSpaces' => new \Twig_Function_Method($this, 'getTypeSpaces', array('is_safe' => array('html'))),
            'getStatusSpaces' => new \Twig_Function_Method($this, 'getStatusSpaces', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
