<?php

namespace ClientBundle\Filter\SQLFilter;

use ClientBundle\Annotation\HasStatusFilter;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class StatusFilter extends SQLFilter
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
        $hasStatusFilter = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(), $this->annotation);

        if (!$hasStatusFilter instanceof HasStatusFilter)
        {
            return '';
        }

        if (!$hasStatusFilter->hasFilter) {
            return '';
        }

        //get status
        try {
            $status = $this->getParameter('status');
        } catch (\InvalidArgumentException $ex) {
            return '';
        }

        return sprintf('%s.%s != %s', $targetTableAlias, $hasStatusFilter->field, $status);
    }


}