<?php

namespace ClientBundle\Factory\Charts;

use Ob\HighchartsBundle\Highcharts\ChartInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractChartsFactory implements ChartsFactoryInterface
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * AbstractChartsFactory constructor.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $this->configureRequired($this->resolver);
        $this->setDefaults($this->resolver);
        $this->configureOptions($this->resolver);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options = array())
    {
        $this->options = $this->resolver->resolve($options);

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return (isset($this->options[$name])) ? $this->options[$name] : $default;
    }


    abstract protected function configureRequired(OptionsResolver $resolver);
    abstract protected function setDefaults(OptionsResolver $resolver);
}