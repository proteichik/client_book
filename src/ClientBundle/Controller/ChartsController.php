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
    
    
    public function callPieAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filterForm = $this->createForm($this->getFilterFormClass('pie'));

        $qb = $this->service->getRepository()->getSumAllEvents();

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            
            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $qb);

        }

        $result = $qb->getQuery()->getResult();

        $data = array();
        foreach ($result as $item) {
            $data[] = array($item['username'], (int) $item['sumCalls']);
        }
        $ob = $this->getPieChart('test', $data);

        return $this->render('/charts/call_pie.html.twig', array('chart' => $ob, 'filterForm' => $filterForm->createView(),));
        
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

        $data = array();
        foreach ($result as $item) {
            $data[] = array($item['username'], (int) $item['countCalls']);
        }
        $ob = $this->getPieChart('test', $data);

        return $this->render('/charts/event.html.twig', array('chart' => $ob));
    }

    protected function getPieChart($name, array $data = array(), array $options = array())
    {
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Browser market shares at a specific website in 2010');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $ob->series(array(array('type' => 'pie','name' => $name, 'data' => $data)));

        return $ob;
    }

    protected function getColumnChart()
    {

    }
}