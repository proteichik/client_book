<?php

namespace ClientBundle\Controller;

use ClientBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends BaseController
{
    protected function setRoutes()
    {
        return array(
            'createAction' => array(
                'route' => 'client_customers',
            ),
        );
    }

}