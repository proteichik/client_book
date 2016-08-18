<?php

namespace Protei\MenuBundle\Model;

class MenuItem implements MenuItemInterface
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var array
     */
    protected $children = array();

    /**
     * MenuItem constructor.
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return (!empty($this->children));
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren($children = array())
    {
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return (!is_null($this->uri)) ? $this->uri : '#';
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getPath()
    {
        $route = $this->getRoute();

        return ($route) ? array('route' => $route) : array('uri' => $this->getUri());
    }

    /**
     * @param array $data
     */
    public function setData(array $data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $data[$key];
            }
        }
    }
}