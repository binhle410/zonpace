<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Core\Page;
use AppBundle\Entity\Core\Post;
use AppBundle\Entity\Space\Space;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text')
                ->add('shortDescription', 'textarea')
                ->add('enabled', 'checkbox')
                ->add('description', 'textarea');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('enabled', null, array('editable' => true));
    }

    public function toString($object)
    {
        return $object instanceof Page
            ? $object->getTitle()
            : 'Page'; // shown in the breadcrumb on the create view
    }
}