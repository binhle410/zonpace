<?php
namespace AppBundle\Form\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use AppBundle\Entity\Accounting\Payroll\Salary;
use AppBundle\Entity\Core\Classification\Tag;

class DateTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
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
        foreach ($data as $item){
            $arr[]= $item->getBlockedDate()->format('Y-m-d');
        }
        return implode(',',$arr);
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
        // no issue number? It's optional, so that's ok
        if (!$data) {
            return;
        }
        $arrTagName = explode(',',$data);
        $collectionTag = new ArrayCollection();
        foreach ($arrTagName as $tagName){
            $tag = $this->manager->getRepository('AppBundle:Core\Classification\Tag')->findOneByName($tagName);
            if(!$tag){
                $tag = new Tag();
                $tag->setName($tagName);
                $tag->setEnabled(true);
                $tag->setCreatedAt(new \DateTime());
                $tag->setUpdatedAt(new \DateTime());
            }
            $collectionTag->add($tag);
        }

        return $collectionTag;
    }
}