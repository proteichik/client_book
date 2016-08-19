<?php

namespace ClientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use ClientBundle\Factory\Menu\MenuConfifFactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $config;

    /**
     * @var MenuConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav side-menu');

        $this->resolver = new OptionsResolver();
        $this->setDefaultsOption($this->resolver);
        $this->setNormalizerOptions($this->resolver);

        $config = $this->getConfig();

        foreach ($config as $item) {
            $this->constructMenu($menu, $item);
        }

//        $menu->addChild('Клиенты', array('uri' => '#'))
//            ->setAttributes(array(
//                'icon' => 'fa fa-home',
//                'dropdown' => true,
//            ));
////            ->setAttribute('icon', 'fa fa-home')
////            ->setAttribute('dropdown', true)
//        ;
//        $menu['Клиенты']->addChild('Мои клиенты', array('route' => 'client_customers'));
//        $menu['Клиенты']->addChild('Добавить клиента', array('route' => 'client_customer.add'));
//
//        $menu->addChild('Сегодня', array('uri' => '#'))
//            ->setAttribute('icon', 'fa fa-edit')
//            ->setAttribute('dropdown', true)
//        ;
//        $menu['Сегодня']->addChild('Мои звонки', array('route' => 'client_call.today'));
//        $menu['Сегодня']->addChild('Мои встречи', array('route' => 'client_meeting.today'));
//                ;
//
//        $menu->addChild('Календарь', array('route' => 'client_calendar.show'))
//            ->setAttribute('icon', 'fa fa-desktop');
//
//        $menu->addChild('Статистика', array('uri' => '#'))
//            ->setAttribute('icon', 'fa fa-bar-chart')
//            ->setAttribute('dropdown', true)
//        ;
//        $menu['Статистика']->addChild('Звонки', array('uri' => '#'))
//            ->setAttribute('dropdown', true)
//        ;
//        $menu['Статистика']->addChild('Встречи', array('uri' => '#'))
//            ->setAttribute('dropdown', true)
//        ;
//        $menu['Статистика']['Звонки']->addChild('Общая', array('uri' => '#'));
//        $menu['Статистика']['Звонки']->addChild('Индивидуальная', array('uri' => '#'));
//        $menu['Статистика']['Встречи']->addChild('Общая', array('uri' => '#'));
//        $menu['Статистика']['Встречи']->addChild('Индивидуальная', array('uri' => '#'));
//
//
//        $menu->addChild('Администрирование', array('uri' => '#'))
//            ->setAttribute('icon', 'fa fa-lock')
//        ;

        return $menu;

    }

    protected function constructMenu($menu, array $options = array())
    {
        $options = array_merge($this->resolver->resolve(), $options);

        $menu->addChild($options['label'], $options['path']);
        $menu[$options['label']]->setAttributes($options['attributes']);

        $children = $options['children'];
        foreach ($children as $child) {
            $this->constructMenu($menu[$options['label']], $child);
        }

        return $menu;
    }

    protected function setDefaultsOption(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'children' => array(),
            'attributes' => array(),
            'uri' => '#',
            'path' => '',
        ));
    }

    protected function setNormalizerOptions(OptionsResolver $resolver)
    {
        $resolver->setNormalizer('path', function (Options $options, $value) {
           if (isset($options['route'])) {
               return array('route' => $options['route']);
           }  else {
               return (isset($options['uri'])) ? array('uri' => $options['uri']) : array('uri' => '#');
           }
        });
    }

    protected function getConfig()
    {
        return array(
            'client' => array(
                'label' => 'Клиенты',
                'uri' => '#',
                'attributes' => array(
                    'icon' => 'fa fa-home',
                    'dropdown' => true,
                ),
                'children' => array(
                    'my_client' => array(
                        'label' => 'Мои клиенты',
                        'route' => 'client_customers',
                    ),
                    'add_client' => array(
                        'label' => 'Добавить клиента',
                        'route' => 'client_customer.add'
                    ),
                ),
            ),
            'today' => array(
                'label' => 'Сегодня',
                'uri' => '#',
                'attributes' => array(
                    'icon' => 'fa fa-edit',
                    'dropdown' => true,
                ),
                'children' => array(
                    'today_calls' => array(
                        'label' => 'Мои звонки',
                        'route' => 'client_call.today',
                    ),
                    'today_meetings' => array(
                        'label' => 'Добавить встречи',
                        'route' => 'client_meeting.today'
                    ),
                ),
            ),
            'calendar' => array(
                'label' => 'Календарь',
                'route' => 'client_calendar.show',
                'attributes' => array(
                    'icon' => 'fa fa-desktop',
                ),
            ),
            'statistic' => array(
                'label' => 'Статистика',
                'uri' => '#',
                'attributes' => array(
                    'icon' => 'fa fa-bar-chart',
                    'dropdown' => true,
                ),
                'children' => array(
                    'chart_call' => array(
                        'label' => 'Звонки',
                        'uri' => '#',
                        'attributes' => array(
                            'dropdown' => true,
                        ),
                        'children' => array(
                            'all_chart' => array(
                                'label' => 'Общая',
                            ),
                            'user_chart' => array(
                                'label' => 'Индивидуальная',
                            ),
                        ),
                    ),
                    'chart_meeting' => array(
                        'label' => 'Встречи',
                        'uri' => '#',
                        'attributes' => array(
                            'dropdown' => true,
                        ),
                        'children' => array(
                            'all_chart' => array(
                                'label' => 'Общая',
                            ),
                            'user_chart' => array(
                                'label' => 'Индивидуальная',
                            ),
                        ),
                    ),
                ),
            ),
        );
    }
}