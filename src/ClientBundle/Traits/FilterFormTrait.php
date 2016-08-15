<?php

namespace ClientBundle\Traits;

trait FilterFormTrait
{
    /**
     * @var array
     */
    protected $filterFormClasses = array();

    /**
     * @param array $filterFormClass
     * @return $this
     */
    public function addFilterFormClass(array $filterFormClass = array())
    {
        if (!isset($filterFormClass['name']) || !isset($filterFormClass['class'])) {
            throw new \InvalidArgumentException('Filter format invalid');
        }

        $this->filterFormClasses[$filterFormClass['name']] = $filterFormClass['class'];

        return $this;
    }

    /**
     * @return array
     */
    public function getFilterFormClasses()
    {
        return $this->filterFormClasses;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getFilterFormClass($name)
    {
        if (!$this->hasFilterFormClass($name)) {
            throw new \InvalidArgumentException(sprintf('Filter %s not found', $name));
        }

        return $this->filterFormClasses[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFilterFormClass($name)
    {
        return (isset($this->filterFormClasses[$name]));
    }
}