<?php

namespace ClientBundle\Factory\Charts;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnChartFactory extends AbstractChartsFactory
{
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureRequired(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'renderTo',
            'text',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'categories' => array(),
            'yData' => array(),
            'legend' => false,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'formatter'
        ));
    }

    /**
     * @param array $data
     * @param array $options
     * @return Highchart
     */
    public function getChart(array $data, array $options = array())
    {
        $this->setOptions($options);

        $ob = new Highchart();

        $ob->chart->renderTo($this->getOption('renderTo')); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text($this->getOption('text'));
        $ob->xAxis->categories($this->getOption('categories', array()));
        //$ob->yAxis($this->getOption('yData', array()));
        $ob->legend->enabled($this->getOption('legend', false));

        if ($this->hasOption('formatter')) {
            $ob->tooltip->formatter($this->getOption('formatter'));
        }

        $ob->series(array($data));

        return $ob;
    }

}