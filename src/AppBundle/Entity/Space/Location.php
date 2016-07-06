<?php

namespace AppBundle\Entity\Space;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="space__location")
 * @ORM\Entity
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    private $streetAddress;
    private $typeSpace;
    private $city;
    private $state;
    private $zipCode;
    private $squareFeet;
    
    
}

