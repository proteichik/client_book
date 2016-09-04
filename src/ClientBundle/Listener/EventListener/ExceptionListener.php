<?php

namespace ClientBundle\Listener\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getException();

        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse(array(
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ), 500);

            $event->setResponse($response);
        }
    }
}