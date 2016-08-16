<?php

namespace ClientBundle\Factory\Charts;

use Ob\HighchartsBundle\Highcharts\ChartInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractChartsFactory
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var ChartInterface
     */
    protected $chart;

    /**
     * AbstractChartsFactory constructor.
     * @param array $options
     * @param ChartInterface $chart
     */
    public function __construct(ChartInterface $chart, array $options = array())
    {
        $resolver = new OptionsResolver();
        $this->configureRequired($resolver);
        $this->setDefaults($resolver);
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
        $this->chart = $chart;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    abstract protected function configureRequired(OptionsResolver $resolver);
    abstract protected function setDefaults(OptionsResolver $resolver);
}