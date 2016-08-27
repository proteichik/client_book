<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Factory\Charts\ChartsFactoryInterface;
use ClientBundle\Factory\Charts\ColumnChartFactory;
use ClientBundle\Factory\Charts\PieChartsFactory;
use ClientBundle\Service\ServiceInterface;
use Doctrine\ORM\QueryBuilder;
use Statistic\BasicBundle\Service\RecordService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseChartController extends Controller
{
    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * @var string
     */
    protected $filterForm;

    /**
     * CharsController constructor.
     * @param ServiceInterface $service
     * @param ContainerInterface $container
     * @param $filterClass
     */
    public function __construct(ServiceInterface $service, ContainerInterface $container, $filterClass)
    {
        $this->setContainer($container);
        $this->service = $service;
        $this->filterForm = $this->createForm($filterClass);
    }

    protected function getPieOptions($type)
    {
        switch ($type)
        {
            case RecordService::TYPE_CALL:
                return array(
                    'renderTo' => 'piechart',
                    'text' => 'Общее количество звонков',
                    'name' => 'звонков',
                );
                break;
            case RecordService::TYPE_MEETING:
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

    protected function getColumnOptions($type)
    {
        switch ($type)
        {
            case RecordService::TYPE_CALL:
                return array(
                    'renderTo' => 'columnchart',
                    'text' => 'Звонки',
                    'name' => 'звонков',
                );
                break;
            case RecordService::TYPE_MEETING:
                return array(
                    'renderTo' => 'columnchart',
                    'text' => 'Встречи',
                    'name' => 'встреч',
                );
                break;
            default:
                return array();
        }
    }

    protected function getChartFactory($type)
    {
        $factory = null;

        switch ($type)
        {
            case 'pie':
                $factory =  new PieChartsFactory();
                break;
            case 'column':
                $factory = new ColumnChartFactory();
                break;
            default:
                throw new \RuntimeException(sprintf('Factory for type %s not found', $type));
        }

        if (!$factory instanceof ChartsFactoryInterface) {
            throw new \RuntimeException(
                sprintf('Chart factory must implements %s'), ChartsFactoryInterface::class);
        }

        return $factory;
    }

    /**
     * @param Request $request
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    protected function handleFilter(Request $request, QueryBuilder $qb)
    {
        if ($request->query->has($this->filterForm->getName())) {
            $this->filterForm->submit($request->query->get($this->filterForm->getName()));

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($this->filterForm, $qb);
            
        }

        return $qb;
    }
}