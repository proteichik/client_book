<?php

namespace ClientBundle\Controller;

use ClientBundle\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Traits\FilterFormTrait;

class CharsController extends Controller
{
    use FilterFormTrait;

    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * @var array
     */
    protected $filterFormClasses = array();

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
        
    }
}