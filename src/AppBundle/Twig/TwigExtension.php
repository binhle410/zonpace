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

    /**
     * @return array
     */
    public function getStatusSpaces()
    {
        $spaceType = [
            0 => 'Disabled',
            1 => 'Enabled',
        ];
        return $spaceType;
    }

    /**
     * @param $object
     * @param $type 1:,all, 2:locationRating, 3:communicationRating ,4 avg locationRating, 5 avg communicationRating
     * @return string
     */
    public function getRatingSpace($object,$type){
        switch ($type){
            //object is Space
            case 1:
                $rating = $this->container->get('app.controller')->getRatingSpace($object);
                break;
            //Object is Booking
            case 2:
                $rating = $object->getRatingLocation();
                break;
            case 3:
                $rating = $object->getRatingCommunication();
                break;
            case 4:
                $rating = $this->container->get('app.controller')->getLocationRatingSpace($object);
                break;
            case 5:
                $rating = $this->container->get('app.controller')->getCommunicationRatingSpace($object);
                break;

        }
        $rating = round($rating);
        $noRating = 5- $rating;
        $html='';
        for ($i=1;$i<=$rating;$i++){
            $html.=' <i class="fa fa-star text-default"></i>';
        }
        for ($i=1;$i<=$noRating;$i++){
            $html.=' <i class="fa fa-star"></i>';
        }
        return $html;
    }

    public function getTotalReviewSpace($space){
        return $this->container->get('app.controller')->getTotalReviewSpace($space);
    }
    public function getTotalEarningSpace($space){
        return $this->container->get('app.controller')->getTotalEarningSpace($space);
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
            'getRatingSpace' => new \Twig_Function_Method($this, 'getRatingSpace', array('is_safe' => array('html'))),
            'getTotalReviewSpace' => new \Twig_Function_Method($this, 'getTotalReviewSpace', array('is_safe' => array('html'))),
            'getTotalEarningSpace' => new \Twig_Function_Method($this, 'getTotalEarningSpace', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
