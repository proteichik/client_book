<?php

namespace ClientBundle\Filter\SQLFilter;

use ClientBundle\Annotation\AbstractOwner;
use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

/**
 * Class ByIdOwnerFilter
 * @package ClientBundle\Filter\SQLFilter
 */
class ByIdOwnerFilter extends SQLFilter
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $annotation;

    /**
     * @param string $annotation
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }

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

        if (empty($this->annotation)) {
            return '';
        }

        if (!is_string($this->annotation)) {
            return '';
        }

        // get class annotation
        $ownerAware = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(), $this->annotation);

        if (!$ownerAware) {
            return '';
        }

        if (!$ownerAware instanceof AbstractOwner)
        {
            return '';
        }

        //get annotation content
        $fieldName = $ownerAware->idField;

        //get user id
        try {
            $param = $this->getParameter('id');
        } catch (\InvalidArgumentException $ex) {
            return '';
        }

        if (empty($param) || empty($fieldName)) {
            return '';
        }

        //get string (example o.user_id = 5)
        $query = sprintf('%s.%s = %s', $targetTableAlias, $fieldName, $param);

        return $query;
    }
}