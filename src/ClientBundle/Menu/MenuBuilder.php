<?php

namespace ClientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav side-menu');

        $menu->addChild('Клиенты', array('uri' => '#'))
            ->setAttribute('icon', 'fa fa-home')
            ->setAttribute('dropdown', true)
        ;
        $menu['Клиенты']->addChild('Мои клиенты', array('route' => 'client_customers'));
        $menu['Клиенты']->addChild('Добавить клиента', array('route' => 'client_customer.add'));

        $menu->addChild('Сегодня', array('uri' => '#'))
            ->setAttribute('icon', 'fa fa-edit')
            ->setAttribute('dropdown', true)
        ;
        $menu['Сегодня']->addChild('Мои звонки', array('route' => 'client_call.today'));
        $menu['Сегодня']->addChild('Мои встречи', array('route' => 'client_meeting.today'));
                ;

        $menu->addChild('Календарь', array('route' => 'client_calendar.show'))
            ->setAttribute('icon', 'fa fa-desktop');

        $menu->addChild('Статистика', array('uri' => '#'))
            ->setAttribute('icon', 'fa fa-bar-chart')
            ->setAttribute('dropdown', true)
        ;
        $menu['Статистика']->addChild('Звонки', array('uri' => '#'))
            ->setAttribute('dropdown', true)
        ;
        $menu['Статистика']->addChild('Встречи', array('uri' => '#'))
            ->setAttribute('dropdown', true)
        ;
        $menu['Статистика']['Звонки']->addChild('Общая', array('uri' => '#'));
        $menu['Статистика']['Звонки']->addChild('Индивидуальная', array('uri' => '#'));
        $menu['Статистика']['Встречи']->addChild('Общая', array('uri' => '#'));
        $menu['Статистика']['Встречи']->addChild('Индивидуальная', array('uri' => '#'));


        $menu->addChild('Администрирование', array('uri' => '#'))
            ->setAttribute('icon', 'fa fa-lock')
        ;

        return $menu;

    }
}