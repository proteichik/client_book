<?php

namespace ClientBundle\Model;

class BaseEntity implements EntityInterface
{
    /**
     * @var int
     */
    protected $status;

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRemoved()
    {
        return ((int) $this->status === self::REMOVED_TYPE);
    }
}
