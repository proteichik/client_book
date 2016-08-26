<?php

namespace Statistic\DoctrineBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Statistic\BasicBundle\Repository\RecordRepositoryInterface;

class RecordRepository extends EntityRepository implements RecordRepositoryInterface
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getSumAllEvents()
    {
        $qb = $this->createQueryBuilder('q');

        $qb->select('SUM(q.countCalls) as sumCalls')
            ->addSelect('SUM(q.countMeetings) as sumMeetings')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->groupBy('q.user')
        ;

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAggregateInfoCalls()
    {
        $qb = $this->createQueryBuilder('q');

        $qb->select('SUM(q.countCalls) as sumCount')
            ->addSelect('u.id as userId')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->groupBy('q.user')
        ;

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAggregateInfoMeetings()
    {
        $qb = $this->createQueryBuilder('q');

        $qb->select('SUM(q.countMeetings) as sumCount')
            ->addSelect('u.id as userId')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->groupBy('q.user')
        ;

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCallsInfoForColumn()
    {
        $qb = $this->createQueryBuilder('q');

        $qb->select('q.countCalls as countEvents')
            ->addSelect('q.date')
            ->addSelect('u.id as userId')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->orderBy('q.date', 'ASC')
        ;

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getMeetingsInfoForColumn()
    {
        $qb = $this->createQueryBuilder('q');

        $qb->select('q.countMeetings as countEvents')
            ->addSelect('q.date')
            ->addSelect('u.id as userId')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->orderBy('q.date', 'ASC')
        ;

        return $qb;
    }
}