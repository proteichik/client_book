<?php

namespace ClientBundle\Model;

interface EntityInterface
{
    const REMOVED_TYPE = -1;

    public function getStatus();
    public function setStatus($status);
}