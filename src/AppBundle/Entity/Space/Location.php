<?php

namespace AppBundle\Entity\Space;

use AppBundle\Entity\Core\City;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="space__location")
 * @ORM\Entity
 */
class Location
{

    const TYPE_SPACE_VACANT_LAND = 'VACANT_LAND';
    const TYPE_SPACE_SPACE_ATTACHED_TO_PROPERTY = 'SPACE_ATTACHED_TO_PROPERTY';
    const TYPE_SPACE_EVENT_SPACE = 'EVENT_SPACE';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(name="street_address",type="string",nullable=true)
     */
    private $streetAddress;
    /**
     * @var string
     * @ORM\Column(name="type_space_optional",type="string",nullable=true)
     */
    private $typeSpaceOptional;
    /**
     * @var string
     * @ORM\Column(name="type_space",type="string",nullable=true)
     */
    private $typeSpace;


    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\City")
     */
    private $city;

    /**
     * @var State
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\State")
     */
    private $state;

    /**
     * @var string
     * @ORM\Column(name="zip_code",type="string",nullable=true)
     */
    private $zipCode;

    /**
     * @var int
     * @ORM\Column(name="square_feet",type="integer",nullable=true)
     */
    private $squareFeet;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * @param string $streetAddress
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }

    /**
     * @return string
     */
    public function getTypeSpaceOptional()
    {
        return $this->typeSpaceOptional;
    }

    /**
     * @param string $typeSpaceOptional
     */
    public function setTypeSpaceOptional($typeSpaceOptional)
    {
        $this->typeSpaceOptional = $typeSpaceOptional;
    }

    /**
     * @return string
     */
    public function getTypeSpace()
    {
        return $this->typeSpace;
    }

    /**
     * @param string $typeSpace
     */
    public function setTypeSpace($typeSpace)
    {
        $this->typeSpace = $typeSpace;
    }

    /**
     * @return int
     */
    public function getSquareFeet()
    {
        return $this->squareFeet;
    }

    /**
     * @param int $squareFeet
     */
    public function setSquareFeet($squareFeet)
    {
        $this->squareFeet = $squareFeet;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    
    
    
    
    
}

