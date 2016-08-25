<?php

namespace ClientBundle\Factory\Charts;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieChartsFactory extends AbstractChartsFactory
{
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureRequired(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'plotOptions',
            'test',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'renderTo',
            'name',
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'plotOptions' => array(
                'allowPointSelect'  => true,
                'cursor'    => 'pointer',
                'dataLabels'    => array('enabled' => false),
                'showInLegend'  => true
            ),
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

        $chart = new Highchart();

        $chart->chart->renderTo($this->getOption('renderTo'));
        $chart->title->text($this->getOption('text'));
        $chart->plotOptions->pie($this->getOption('plotOptions'));

        $chart->series(array(array('type' => 'pie','name' => $this->getOption('name'), 'data' => $data)));

        return $chart;
    }

}