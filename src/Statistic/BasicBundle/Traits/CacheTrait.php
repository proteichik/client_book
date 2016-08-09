<?php

namespace Statistic\BasicBundle\Traits;

trait CacheTrait
{
    /**
     * @var array
     */
    protected $_cache = array();

    /**
     * @param $key
     * @return bool
     */
    protected function inCache($key)
    {
        return isset($this->_cache[$key]);
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setToCache($key, $value)
    {
        if (!$this->inCache($key)) {
            $this->_cache[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return bool|object
     */
    protected function getFromCache($key)
    {
        if (!$this->inCache($key)) {
            return null;
        }

        return $this->_cache[$key];
    }
}