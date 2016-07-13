<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\Space\BlockedDateBooking;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTransformer implements DataTransformerInterface
{
    private $manager;
    private $dateBooking;

    public function __construct(ObjectManager $manager, $dateBooking)
    {
        $this->manager = $manager;
        $this->dateBooking = $dateBooking;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  ArrayCollection|null $issue
     * @return string
     */
    public function transform($data)
    {
        $arr = [];
        foreach ($data as $item) {
            $date = $item->getBlockedDate()->format('Y-m-d');
            $arr[$item->getBlockedDate()->format('Y')][$item->getBlockedDate()->format('m')][$date] = $date;
        }
        //for pass to client {} instead []
        $arr = count($arr) == 0 ? new \stdClass() : $arr;
        return json_encode($arr);
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $userId
     * @return ArrayCollection|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($data)
    {

        $data = json_decode($data, true);
        if($data == null){
            return;
        }
        $listBlockedDate = [];
        foreach ($data as $year) {
            foreach ($year as $month) {
                foreach ($month as $date) {
                    $listBlockedDate[] = $date;
                }
            }
        }
        $collection = new ArrayCollection();
        foreach ($listBlockedDate as $date) {
            $blockedDateBooking = new BlockedDateBooking();
            $blockedDateBooking->setBlockedDate(new \DateTime($date));
            $blockedDateBooking->setDateBooking($this->dateBooking);
            $this->manager->persist($blockedDateBooking);
//            $collection->add($blockedDateBooking);
        }
        $this->manager->flush();


        return $collection;
    }
}