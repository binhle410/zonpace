<?php
namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Show\ShowMapper;

class BlogPostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Post')
                ->with('Content', array('class' => 'col-md-9'))
                    ->add('title', 'text')
                    ->add('body', 'textarea')
                ->end()
            ->end()
            ->tab('Publish Options')
                ->with('Meta data', array('class' => 'col-md-3'))
                    ->add('category', 'sonata_type_model', array(
                        'class' => 'AppBundle\Entity\Category',
                        'property' => 'name',
                    ))
                ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
//            ->add('category', null, array(), 'sonata_type_model', array(
//                'class'    => 'AppBundle\Entity\Category',
//                'property' => 'name',
//            ))
            ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
                    ->add('category.name')
                    ->add('draft')
            ;
    }


    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}