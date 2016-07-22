<?php

namespace ClientBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class UserAware
 * @package ClientBundle\Annotation
 *
 * @Annotation
 * @Target("CLASS")
 */
final class HasStatusFilter
{
    /**
     * @var bool
     */
    public $hasFilter = true;

    /**
     * @var string
     */
    public $field = 'status';
}