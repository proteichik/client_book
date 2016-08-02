<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends Controller
{
    public function showAction(Request $request)
    {
        return $this->render('calendar/show.html.twig');
    }
}