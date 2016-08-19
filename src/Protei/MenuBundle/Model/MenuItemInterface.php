<?php

namespace Protei\MenuBundle\Model;

interface MenuItemInterface
{
    public function hasChildren();
    public function getChildren();
    public function getLabel();
    public function getPath();
}