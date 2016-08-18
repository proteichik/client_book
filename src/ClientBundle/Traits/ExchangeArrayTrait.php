<?php

namespace ClientBundle\Traits;

/**
 * Class ExchangeArrayTrait
 * @package ClientBundle\Traits
 */
trait ExchangeArrayTrait
{
    /**
     * @param array $data
     */
    public function exchangeArray(array $data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $data[$key];
            }
        }
    }
}