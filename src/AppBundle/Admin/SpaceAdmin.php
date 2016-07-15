<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Space\Space;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SpaceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('enabled')
            ->add('user');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user', null, array(
                'sortable' => 'context.username',
            ))
            ->addIdentifier('name')
        ->add('enabled', null, array('editable' => true));
    }
    public function toString($object)
    {
        return $object instanceof Space
            ? $object->getName()
            : 'Space'; // shown in the breadcrumb on the create view
    }
}