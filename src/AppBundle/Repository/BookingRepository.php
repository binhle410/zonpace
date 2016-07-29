<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Booking\Booking;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use DoctrineExtensions\Query\Mysql\Acos;
use DoctrineExtensions\Query\Mysql\Cos;
use DoctrineExtensions\Query\Mysql\Sin;
use DoctrineExtensions\Query\Mysql\Radians;

/**
 * BlogPostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends EntityRepository
{
    /**
     *  booking of user
     * @param $user
     * @param $query
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findMyBooking($user, $query)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->where($expr->eq('booking.user', ':user'))
            ->setParameter('user', $user);
        if (isset($query['type-space']) && $query['type-space'] != '') {
            $qb->andWhere('location.typeSpace = :typeSpace')
                ->setParameter('typeSpace', $query['type-space']);
        }
        if (isset($query['status-booking']) && $query['status-booking'] != '') {
            if ($query['status-booking'] == Booking::STATUS_PENDING || $query['status-booking'] == Booking::STATUS_CANCELLED) {
                $qb->andWhere('booking.status = :status')
                    ->setParameter('status', $query['status-booking']);
            } else {
                $qb->andWhere('booking.status = :status')
                    ->setParameter('status', Booking::STATUS_SUCCESS);
                if ($query['status-booking'] == 'ACTIVE') {
                    $qb->andWhere('(booking.dateFrom <= CURRENT_DATE() AND booking.dateTo >= CURRENT_DATE()) OR (booking.dateFrom > CURRENT_DATE())');
                }
                if ($query['status-booking'] == 'COMPLETED') {
                    $qb->andWhere('booking.dateTo < CURRENT_DATE()');
                }
            }
        }
        return $qb;

    }

    /**
     *  booking of host
     * @param $user
     * @param $query
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findHostBooking($user, $query)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->join('booking.space', 'space')
            ->join('space.location', 'location')
            ->where($expr->eq('space.user', ':user'))
            ->setParameter('user', $user);
        if (isset($query['type-space']) && $query['type-space'] != '') {
            $qb->andWhere('location.typeSpace = :typeSpace')
                ->setParameter('typeSpace', $query['type-space']);
        }
        if (isset($query['status-booking']) && $query['status-booking'] != '') {
            if ($query['status-booking'] == Booking::STATUS_PENDING || $query['status-booking'] == Booking::STATUS_CANCELLED) {
                $qb->andWhere('booking.status = :status')
                    ->setParameter('status', $query['status-booking']);
            } else {
                $qb->andWhere('booking.status = :status')
                    ->setParameter('status', Booking::STATUS_SUCCESS);
                if ($query['status-booking'] == 'ACTIVE') {
                    $qb->andWhere('(booking.dateFrom <= CURRENT_DATE() AND booking.dateTo >= CURRENT_DATE()) OR (booking.dateFrom > CURRENT_DATE())');
                }
                if ($query['status-booking'] == 'COMPLETED') {
                    $qb->andWhere('booking.dateTo < CURRENT_DATE()');
                }
            }
        }
        return $qb;

    }

    /**
     *  booking of host
     * @param $user
     * @param $query
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findHostTransaction($user, $query)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->join('booking.space', 'space')
            ->join('space.location', 'location')
            ->where($expr->eq('space.user', ':user'))
            ->setParameter('user', $user)
            ->andWhere('booking.status = :status')
            ->setParameter('status', Booking::STATUS_SUCCESS)
            ->orderBy('booking.createdAt', 'DESC');
        if (isset($query['type-sort']) && $query['type-sort'] != '') {
            $qb->orderBy('booking.createdAt', $query['type-sort']);
        }
        if (isset($query['status-booking']) && $query['status-booking'] != '') {
            if ($query['status-booking'] == 'ACTIVE') {
                $qb->andWhere('(booking.dateFrom <= CURRENT_DATE() AND booking.dateTo >= CURRENT_DATE()) OR (booking.dateFrom > CURRENT_DATE())');
            }
            if ($query['status-booking'] == 'COMPLETED') {
                $qb->andWhere('booking.dateTo < CURRENT_DATE()');
            }
        }
        return $qb;

    }

    /*
     * Get Rating for host--------------------------------------------------
     */
    public function getRatingHost($host)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->select('AVG((booking.ratingLocation + booking.ratingCommunication)/2)')
            ->join('booking.space', 'space')
            ->where($expr->eq('space.user', ':user'))
            ->setParameter('user',$host);

        return $qb->getQuery()->getSingleScalarResult();
    }
    public function getCommunicationRatingHost($host)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->select('AVG(booking.ratingCommunication)')
            ->join('booking.space', 'space')
            ->where($expr->eq('space.user', ':user'))
            ->setParameter('user',$host);

        return $qb->getQuery()->getSingleScalarResult();

    }

    public function getLocationRatingHost($host)
    {
        $expr = new Expr();
        $qb = $this->createQueryBuilder('booking')
            ->select('AVG(booking.ratingLocation)')
            ->join('booking.space', 'space')
            ->where($expr->eq('space.user', ':user'))
            ->setParameter('user',$host);

        return $qb->getQuery()->getSingleScalarResult();

    }

    /*
     * Get Rating for a space--------------------------------------------------
     */
    public function getRatingSpace($space)
    {
        return $this->_em->createQuery('select AVG((b.ratingLocation + b.ratingCommunication)/2) from AppBundle\Entity\Booking\Booking b where b.space =:space and b.ratingLocation > 0')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }

    public function getLocationRatingSpace($space)
    {
        return $this->_em->createQuery('select AVG(b.ratingLocation) from AppBundle\Entity\Booking\Booking b where b.space =:space and b.ratingLocation > 0')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }

    public function getCommunicationRatingSpace($space)
    {
        return $this->_em->createQuery('select AVG(b.ratingCommunication) from AppBundle\Entity\Booking\Booking b where b.space =:space and b.ratingLocation > 0')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }

    /*
     * Get some infor--------------------------------------------------
     */

    public function getTotalReviewSpace($space)
    {
        return $this->_em->createQuery('select COUNT(b.id) from AppBundle\Entity\Booking\Booking b where b.space =:space and b.ratingLocation > 0')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }

    public function getTotalEarningSpace($space)
    {
        return $this->_em->createQuery('select SUM (b.totalPrice) from AppBundle\Entity\Booking\Booking b where b.space =:space')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }

    public function getTotalBookingSpace($space)
    {
        return $this->_em->createQuery('select COUNT (b.id) from AppBundle\Entity\Booking\Booking b where b.space =:space')
            ->setParameter('space', $space)
            ->getSingleScalarResult();
    }
}
