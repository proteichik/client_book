<?php

namespace Statistic\MongoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Statistic\BasicBundle\Model\Record as BaseRecord;

/**
 * Class Statistic
 * @package Statistic\MongoBundle
 *
 * @MongoDB\Document
 */
class Record extends BaseRecord
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDb\Field(type="date")
     */
    protected $date;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $countCalls = 0;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $countMeetings = 0;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="stats")
     */
    protected $user;
}
