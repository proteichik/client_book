<?php

namespace ClientBundle\Listener\EventListener;
use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use ClientBundle\Service\ServiceInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalendarEventListener
 * @package ClientBundle\Listener\EventListener
 */
class CalendarCallEventListener extends EventCalendarListener
{
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('header', '[Звонок]');
    }

}