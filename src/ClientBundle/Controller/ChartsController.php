<?php

namespace ClientBundle\Controller;

use ClientBundle\Controller\Base\BaseChartController;
use Symfony\Component\HttpFoundation\Request;

class ChartsController extends BaseChartController
{
    public function pieAction(Request $request, $type)
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

        $data = $this->preparePieData($type, $result);
        $ob = $this->getPieChart($data, $this->getPieOptions($type));

        return $this->render('/charts/pie.html.twig', array('chart' => $ob, 'filterForm' => $filterForm->createView(),));
        
    }


}