<?php

namespace AppBundle\Entity\Space;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="space__price")
 * @ORM\Entity
 */
class Price
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
     * @var float
     * @ORM\Column(name="daily",type="float",precision=4,scale=2,nullable=true)
     */
    private $daily;
    /**
     * @var float
     * @ORM\Column(name="weekly_discount",type="float",precision=2,scale=2,nullable=true)
     */
    private $weeklyDiscount;
    /**
     * @var float
     * @ORM\Column(name="monthly_discount",type="float",precision=2,scale=2,nullable=true)
     */
    private $monthlyDiscount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getDaily()
    {
        return $this->daily;
    }

    /**
     * @param float $daily
     */
    public function setDaily($daily)
    {
        $this->daily = $daily;
    }

    /**
     * @return float
     */
    public function getWeeklyDiscount()
    {
        return $this->weeklyDiscount;
    }

    /**
     * @param float $weeklyDiscount
     */
    public function setWeeklyDiscount($weeklyDiscount)
    {
        $this->weeklyDiscount = $weeklyDiscount;
    }

    /**
     * @return float
     */
    public function getMonthlyDiscount()
    {
        return $this->monthlyDiscount;
    }

    /**
     * @param float $monthlyDiscount
     */
    public function setMonthlyDiscount($monthlyDiscount)
    {
        $this->monthlyDiscount = $monthlyDiscount;
    }
    
    



}

