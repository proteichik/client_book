<?php

namespace ClientBundle\Listener\EventListener;
use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use ClientBundle\Service\ServiceInterface;

/**
 * Class CalendarEventListener
 * @package ClientBundle\Listener\EventListener
 */
class CalendarCallEventListener
{

    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * @param ServiceInterface $service
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param ServiceInterface $service
     * @return $this
     */
    public function setService(ServiceInterface $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $callEvents = $this->getService()->getQueryBuilder('q')
            ->select('q', 'c')
            ->join('q.customer', 'c')
            ->where('q.date BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();;


        foreach ($callEvents as $callEvent) {

            // create an event with a start/end time, or an all day event
            $eventEntity = new EventEntity('[Звонок] ' . $callEvent->getCustomer()->getCompany(),
                $callEvent->getDate(), $callEvent->getDate());

            //optional calendar event settings
            $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
            $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);

        }
    }
}