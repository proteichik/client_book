<?php

namespace ClientBundle\Listener\EventSubscriber;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    /**
     * RegistrationSubscriber constructor.
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
        );
    }

    /**
     * @param GetResponseUserEvent $event
     */
    public function onRegistrationInitialize(GetResponseUserEvent $event)
    {
        $url = $this->router->generate('fos_user_security_login');
        $response = new RedirectResponse($url);

        $event->setResponse($response);
    }

}