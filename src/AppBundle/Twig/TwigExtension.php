<?php

namespace AppBundle\Twig;


use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Space;
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
        $spaceStatus = [
            'disabled' => 'Disabled',
            'enabled' => 'Enabled',
        ];
        return $spaceStatus;
    }
    /**
     * @return array
     */
    public function getStatusBookings()
    {
        $statusBooking = [
            'PENDING' => 'Pending',
            'CANCELLED' => 'Cancelled',
            'ACTIVE' => 'Active',
            'COMPLETED' => 'Completed',
        ];
        return $statusBooking;
    }
    /**
     * @return array
     */
    public function getTypeSorts()
    {
        $statusBooking = [
            'ASC' => 'Date ASC',
            'DESC' => 'Date DESC',
        ];
        return $statusBooking;
    }
    /**
     * @return array
     */
    public function getStatusBookingSuccess()
    {
        $statusBooking = [
            'ACTIVE' => 'Active',
            'COMPLETED' => 'Completed',
        ];
        return $statusBooking;
    }



    public function getRatingBooking($booking,$type){
        switch ($type){
            case 1:
                $rating = $booking->getRatingLocation();
                break;
            case 2:
                $rating = $booking->getRatingCommunication();
                break;
        }
        return $this->generateRatingStar($rating);
    }
    public function getRatingSpace($space,$type){
        switch ($type){
            //object is Space
            case 1:
                $rating = $this->container->get('app.controller')->getRatingSpace($space);
                break;
            case 2:
                $rating = $this->container->get('app.controller')->getLocationRatingSpace($space);
                break;
            case 3:
                $rating = $this->container->get('app.controller')->getCommunicationRatingSpace($space);
                break;

        }
        return $this->generateRatingStar($rating);
    }

    /**
     * @return string
     */
    public function getRatingHost($user,$type){
        switch ($type){
            //object is Space
            case 1:
                $rating = $this->container->get('app.controller')->getRatingHost($user);
                break;
            case 2:
                $rating = $this->container->get('app.controller')->getLocationRatingHost($user);
                break;
            case 3:
                $rating = $this->container->get('app.controller')->getCommunicationRatingHost($user);
                break;

        }
        return $this->generateRatingStar($rating);
    }
    public function generateRatingStar($rating){
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
    public function getTotalBookingSpace($space){
        return $this->container->get('app.controller')->getTotalBookingSpace($space);
    }
    public function getImageSpace(Space $space, $width, $height){
        return $this->container->get('app.controller')->getImageSpace($space,$width,$height);
    }
    public function getStatusBooking(Booking $booking){
        return $this->container->get('app.controller')->getStatusBooking($booking);
    }

    public function checkAvailableBooking(Space $space,$dateFrom,$dateTo){
        return $this->container->get('app.controller')->checkAvailableBooking($space,$dateFrom,$dateTo);
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
            'getRatingBooking' => new \Twig_Function_Method($this, 'getRatingBooking', array('is_safe' => array('html'))),
            'getRatingSpace' => new \Twig_Function_Method($this, 'getRatingSpace', array('is_safe' => array('html'))),
            'getRatingHost' => new \Twig_Function_Method($this, 'getRatingHost', array('is_safe' => array('html'))),
            'getTotalReviewSpace' => new \Twig_Function_Method($this, 'getTotalReviewSpace', array('is_safe' => array('html'))),
            'getTotalEarningSpace' => new \Twig_Function_Method($this, 'getTotalEarningSpace', array('is_safe' => array('html'))),
            'getTotalBookingSpace' => new \Twig_Function_Method($this, 'getTotalBookingSpace', array('is_safe' => array('html'))),
            'getImageSpace' => new \Twig_Function_Method($this, 'getImageSpace', array('is_safe' => array('html'))),
            'getStatusBookings' => new \Twig_Function_Method($this, 'getStatusBookings', array('is_safe' => array('html'))),
            'getStatusBooking' => new \Twig_Function_Method($this, 'getStatusBooking', array('is_safe' => array('html'))),
            'getTypeSorts' => new \Twig_Function_Method($this, 'getTypeSorts', array('is_safe' => array('html'))),
            'getStatusBookingSuccess' => new \Twig_Function_Method($this, 'getStatusBookingSuccess', array('is_safe' => array('html'))),
            'checkAvailableBooking' => new \Twig_Function_Method($this, 'checkAvailableBooking', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
