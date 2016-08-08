<?php

namespace ClientBundle\Repository;
use ClientBundle\Entity\AbstractEvent;

/**
 * Class EventRepository
 * @package ClientBundle\Repository
 */
class EventRepository extends AbstractRepository
{
    /**
     * Get today event
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getTodayQB()
    {
        $today_begin = new \DateTime();
        $today_begin->setTime(0,0,0);

        $today_end = new \DateTime();
        $today_end->setTime(23,59,59);

        //$qb =  $this->createQueryBuilder('q')->join('q.customer', 'c');
        $qb = $this->_em->createQueryBuilder()
            ->select(array('q', 'c', 'u'))
            ->from($this->_entityName, 'q')
            ->join('q.customer', 'c')
            ->join('q.user', 'u')
        ;

        $qb->where('q.status = :status')
            ->andWhere('q.date BETWEEN :date_begin AND :date_end')
            ->setParameter('status', AbstractEvent::PLANNED_TYPE)
            ->setParameter('date_begin', $today_begin)
            ->setParameter('date_end', $today_end)
        ;

        return $qb;
    }

    /**
     * @return array
     */
    public function getUnProcessEvents()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select(array('q', 'u'))
            ->from($this->_entityName, 'q')
            ->join('q.user', 'u')
            ->where('q.process = :process')
            ->andWhere('q.status = :status')
            ->setParameter('process', 0)
            ->setParameter('status', AbstractEvent::DONE_TYPE)
            ;

        return $qb->getQuery()->getResult();
    }
}