<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Core\Post;
use AppBundle\Entity\Space\Space;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Doctrine\ORM\EntityRepository;


class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('type', 'choice',[
                'choices'=>[
                    'NEW' =>'NEW',
                    'BLOG' =>'BLOG',
                ],
            ])
            ->add('title', 'text')
                ->add('shortDescription', 'textarea')
                ->add('description', 'textarea',['attr'=>['class'=>'summernote']])
                ->add('enabled', 'checkbox')

            ->add('category', 'choice',[
                'choices'=>[
                    'TIPS' =>'TIPS',
                    'HOME_IMPROVEMENT' =>'HOME_IMPROVEMENT',
                    'MARKET_TRENDS' =>'MARKET_TRENDS',
                    'CELEBRITY_REAL_ESTATE' =>'CELEBRITY_REAL_ESTATE',
                ],
            ]);

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('type')
            ->add('category')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('type')
            ->add('category')
            ->add('enabled', null, array('editable' => true));
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Post'; // shown in the breadcrumb on the create view
    }
}