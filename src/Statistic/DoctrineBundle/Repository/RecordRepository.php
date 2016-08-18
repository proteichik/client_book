<?php

namespace Statistic\DoctrineBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecordRepository extends EntityRepository
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
}