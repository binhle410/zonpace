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


    public function getUrl(Media $media,$context='default',$format='medium'){
        return $this->container->get('app.media.retriever')->getPublicURL($media,$context,$format);
    }

    public function getlAphabetNameSpace($index){
        $aphabet = range('A','Z');
        if(isset($aphabet[$index])){
            return $aphabet[$index];
        }
        return 'N/A';
    }
    public function getFunctions()
    {
        return array(
            'getParameter' => new \Twig_Function_Method($this, 'getParameter', array('is_safe' => array('html'))),
            'getUrl' => new \Twig_Function_Method($this, 'getUrl', array('is_safe' => array('html'))),
            'getlAphabetNameSpace' => new \Twig_Function_Method($this, 'getlAphabetNameSpace', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
