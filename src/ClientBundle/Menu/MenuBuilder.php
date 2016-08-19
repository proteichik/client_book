<?php

namespace ClientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class MenuBuilder extends AbstractBuilder implements ContainerAwareInterface
{
    /**
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(array $options = array())
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav side-menu');

        $config = $this->getConfig('main_menu');

        foreach ($config as $item) {
            $this->constructMenu($menu, $item);
        }

        return $menu;

    }


}