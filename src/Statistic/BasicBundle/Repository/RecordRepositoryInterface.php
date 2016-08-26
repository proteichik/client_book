<?php

namespace Statistic\BasicBundle\Repository;

interface RecordRepositoryInterface
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAggregateInfoCalls();

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAggregateInfoMeetings();

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCallsInfoForColumn();

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getMeetingsInfoForColumn();
}