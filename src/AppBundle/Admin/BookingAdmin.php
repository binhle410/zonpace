<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Core\User;
use AppBundle\Entity\Space\Space;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BookingAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
//        $formMapper->add('', 'text');
//        $formMapper->add('firstName', 'text');
//        $formMapper->add('lastName', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('user.email')
            ->add('space.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user.email', null, array(
                'sortable' => 'user.email',
            ))
            ->add('space.name', null, array(
                'sortable' => 'space.name',
            ))
            ->add('space.dateBooking.dateFrom', null, array(
                'sortable' => 'space.dateBooking.dateFrom',
            ))
            ->add('space.dateBooking.dateTo', null, array(
                'sortable' => 'space.dateBooking.dateTo',
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'delete' => array(),
                )
            ));
    }
    public function toString($object)
    {
        return $object instanceof Booking
            ? $object->getName()
            : 'Bookings'; // shown in the breadcrumb on the create view
    }
}