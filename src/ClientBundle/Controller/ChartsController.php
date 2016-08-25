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

        $qb = $this->service->getQueryBuilder('q')->select(array('q', 'u'))->join('q.user', 'u');

        $this->handleFilter($request, $qb);

        $qb->andWhere('u.id = :uid')->setParameter('uid', $user_id);

        $result = $qb->getQuery()->getResult();

        var_dump($result); die;

        return new Response(print_r($result));
    }


}