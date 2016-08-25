<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Factory\Charts\PieChartsFactory;
use ClientBundle\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClientBundle\Traits\FilterFormTrait;

abstract class BaseChartController extends Controller
{
    use FilterFormTrait;

    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * CharsController constructor.
     * @param ServiceInterface $service
     * @param array $filterFormClasses
     */
    public function __construct(ServiceInterface $service, array $filterFormClasses = array())
    {
        $this->service = $service;
        $this->filterFormClasses = $filterFormClasses;
    }

    protected function getPieOptions($type)
    {
        switch ($type)
        {
            case 'call':
                return array(
                    'renderTo' => 'piechart',
                    'text' => 'Общее количество звонков',
                    'name' => 'звонков',
                );
                break;
            case 'meeting':
                return array(
                    'renderTo' => 'piechart',
                    'text' => 'Общее количество встреч',
                    'name' => 'встреч',
                );
                break;
            default:
                return array();
        }
    }

    protected function getPieChart(array $data = array(), array $options = array())
    {
        $chartFactory = new PieChartsFactory();
        return $chartFactory->getChart($data, $options);
    }

    protected function getColumnChart()
    {

    }
}