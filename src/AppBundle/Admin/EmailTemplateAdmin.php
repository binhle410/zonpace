<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Core\EmailTemplate;
use AppBundle\Entity\Core\Post;
use AppBundle\Entity\Space\Space;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Doctrine\ORM\EntityRepository;


class EmailTemplateAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('code', 'text',['attr'=>['readonly'=>true]])
            ->add('subject', 'text')
                ->add('param', 'text',['attr'=>['readonly'=>true]])
                ->add('body', 'textarea',['attr'=>['class'=>'summernote','required'=>false]]);




    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('code');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code')
            ->add('subject')
            ->add('param');
    }

    public function toString($object)
    {
        return $object instanceof EmailTemplate
            ? $object->getSubject()
            : 'Email Template'; // shown in the breadcrumb on the create view
    }
}