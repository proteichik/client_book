<?php

namespace ClientBundle\Model;

/**
 * Interface RouteInterface
 * @package ClientBundle\Model
 */
interface RouteInterface
{
    public function setRoute($route);
    public function getRoute();
    public function setParams($params);
    public function getParams();
    public function setCode($code);
    public function getCode();
}