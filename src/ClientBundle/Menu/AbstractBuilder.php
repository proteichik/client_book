<?php

namespace ClientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ClientBundle\Factory\ParserFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractBuilder
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $configFileName;

    /**
     * @var ParserFactoryInterface
     */
    protected $parser;

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @param FactoryInterface $factory
     * @param ParserFactoryInterface $parser
     * @param $configFileName
     */
    public function __construct(FactoryInterface $factory, ParserFactoryInterface $parser, $configFileName)
    {
        $this->factory = $factory;
        $this->configFileName = $configFileName;
        $this->parser = $parser;

        $this->resolver = new OptionsResolver();
        $this->setDefinedOptions($this->resolver);
        $this->setRequiredOptions($this->resolver);
        $this->setDefaultsOption($this->resolver);
        $this->setNormalizerOptions($this->resolver);
    }


    /**
     * @param \Knp\Menu\ItemInterface $menu
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    protected function constructMenu($menu, array $options = array())
    {
        $options = $this->resolver->resolve($options);
        $menu->addChild($options['label'], $options['path']);
        $menu[$options['label']]->setAttributes($options['attributes']);

        $children = $options['children'];
        foreach ($children as $child) {
            $this->constructMenu($menu[$options['label']], $child);
        }

        return $menu;
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultsOption(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'children' => array(),
            'attributes' => array(),
            'uri' => '#',
            'path' => '',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
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

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefinedOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'children',
            'attributes',
            'uri',
            'route',
            'path',
            'label',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'label',
        ));
    }

    /**
     * @param $menuName
     * @return array
     */
    protected function getConfig($menuName)
    {
        $filepath = $this->container->getParameter('kernel.root_dir') . '/config/' . $this->configFileName;

        $config = $this->parser->parse($filepath);

        if (!isset($config[$menuName])) {
            throw new \RuntimeException(sprintf('Config for %s not found', $menuName));
        }

        return $config[$menuName];
    }
}