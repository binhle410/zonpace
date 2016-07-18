<?php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="core__city")
 * @ORM\Entity
 */
class City
{
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
     * @ORM\Column(name="name",type="string",nullable=true)
     */
    private $name;

   /**
     * @var string
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\State"))
     */
    private $state;
    

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }




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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    
    
    
}

