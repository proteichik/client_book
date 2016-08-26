<?php

namespace ClientBundle\Controller;

use ClientBundle\Controller\Base\BaseChartController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChartsController extends BaseChartController
{
    public function pieAction(Request $request, $type)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $qb = $this->handleFilter($request, $this->service->getAggregateInfoByEvent($type));

        $result = $qb->getQuery()->getResult();

        $data = array();
        foreach ($result as $item) {
            $data[] = array($item['username'], (int) $item['sumCount']);
        }

        $ob = $this->getChartFactory('pie')->getChart($data, $this->getPieOptions($type));

        return $this->render('/charts/pie.html.twig',
            array('chart' => $ob, 'filterForm' => $this->filterForm->createView(), 'data' => $result));
        
    }

    public function columnAction(Request $request, $user_id, $type)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $qb = $this->handleFilter($request, $this->service->getInfoByTypeForColumnChart($type));

        $qb->andWhere('u.id = :uid')->setParameter('uid', $user_id);

        $result = $qb->getQuery()->getResult();

        $data = array();
        $categories = array();
        foreach ($result as $item) {
            $data[] = $item['countEvents'];
            $categories[] = $item['date']->format('Y-m-d');
        }

        $options = $this->getColumnOptions($type);
        $options['categories'] = $categories;

        $ob = $this->getChartFactory('column')->getChart($data, $options);

        return $this->render('/charts/column.html.twig',
            array('chart' => $ob, 'filterForm' => $this->filterForm->createView()));
    }


}