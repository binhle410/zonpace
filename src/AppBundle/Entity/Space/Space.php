<?php

namespace AppBundle\Entity\Space;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="space__space")
 * @ORM\Entity
 */
class Space
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->features = new ArrayCollection();
    }

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

    /**
     * @var Gallery
     * @ORM\ManyToOne(targetEntity="Gallery",cascade={"persist","remove"})
     */
    private $photo;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location",cascade={"persist","remove"})
     */
    private $location;
    /**
     * @var Price
     * @ORM\ManyToOne(targetEntity="Price",cascade={"persist","remove"})
     */
    private $price;

    /**
     * @var DateBooking
     * @ORM\ManyToOne(targetEntity="DateBooking",cascade={"persist","remove"})
     */
    private $dateBooking;

    /**
     * @var Feature
     * @ORM\ManyToMany(targetEntity="Feature")
     * @ORM\JoinTable(name="space__space_feature",
     *      joinColumns={@ORM\JoinColumn(name="space_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="feature_id", referencedColumnName="id")}
     *      )
     */
    private $features;


    public function addFeature(Feature $feature){
        $this->features->add($feature);
        return $this;
    }
    public function removeFeature(Feature $feature){
        $this->features->removeElement($feature);
        return $this;
    }
    


}

