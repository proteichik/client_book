<?php

namespace ClientBundle\Controller;

use ClientBundle\Service\ServiceInterface;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Traits\FilterFormTrait;

class ChartsController extends Controller
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

    public function eventAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $qb = $this->service->getQueryBuilder('q');
        $qb->select('SUM(q.countCalls) as countCalls')
            ->addSelect('u.username')
            ->join('q.user', 'u')
            ->groupBy('q.user')
        ;

        $result = $qb->getQuery()->getResult();
        var_dump($result);


        return $this->render('/charts/event.html.twig');
    }

    protected function getPieChart($name, array $data = array(), array $options = array())
    {
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Browser market shares at a specific website in 2010');
        $ob->plotOptions->pie($options);
        $ob->series(array(array('type' => 'pie','name' => $name, 'data' => $data)));
    }

    protected function getColumnChart()
    {

    }
}