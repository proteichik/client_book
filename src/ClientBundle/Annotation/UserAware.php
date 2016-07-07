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
final class UserAware
{
    /**
     * @var string
     */
    public $userFieldName;
}