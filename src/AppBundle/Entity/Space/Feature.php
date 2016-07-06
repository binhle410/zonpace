<?php

namespace AppBundle\Entity\Space;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="space__feature")
 * @ORM\Entity
 */
class Feature
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
        $this->enabled = true;
    }

    /**
     * @var string
     * @ORM\Column(name="name",type="text")
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean")
     */

    private $enabled;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;
}

