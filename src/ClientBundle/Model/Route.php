<?php

namespace ClientBundle\Model;

use ClientBundle\Traits\ExchangeArrayTrait;

/**
 * Class Route
 * @package ClientBundle\Model
 */
class Route implements RouteInterface
{
    use ExchangeArrayTrait;
    /**
     * @var string
     */
    protected $route;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var int
     */
    protected $code = 302;

    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams($params = array())
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode($code = 302)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }


}