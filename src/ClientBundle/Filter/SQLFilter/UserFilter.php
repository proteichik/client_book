<?php

namespace ClientBundle\Filter\SQLFilter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

class UserFilter extends SQLFilter
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param Reader $reader
     */
    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     * @return string
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

        // get class annotation @UserAware
        $userAware = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(), 'ClientBundle\\Annotation\\UserAware');

        if (!$userAware) {
            return '';
        }

        //get annotation content
        $fieldName = $userAware->userFieldName;

        //get user id
        try {
            $userId = $this->getParameter('id');
        } catch (\InvalidArgumentException $ex) {
            return '';
        }

        if (empty($userId) || empty($fieldName)) {
            return '';
        }

        //get string (example o.user_id = 5)
        $query = sprintf('%s.%s = %s', $targetTableAlias, $fieldName, $userId);

        return $query;
    }
}