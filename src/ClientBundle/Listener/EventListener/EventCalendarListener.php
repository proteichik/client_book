<?php

namespace ClientBundle\Listener\EventListener;

use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Service\ServiceInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class EventCalendarListener
{
    protected $options = array();
    protected $service;

    public function __construct(ServiceInterface $service)
    {
        $resolver = new OptionsResolver();
        $this->setDefaults($resolver);
        $this->configureOptions($resolver);


        $this->options = $resolver->resolve();
        $this->service = $service;

    }

    public function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'bgColor' => '#26B99A',
            'fbColor' => '#FFFFFF',
        ));

        $resolver->setRequired(array(
            'header'
        ));
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        //overriding
    }

    public function getEvents(\DateTime $startDate, \DateTime $endDate)
    {
        return $this->service->getQueryBuilder('q')
            ->select('q', 'c')
            ->join('q.customer', 'c')
            ->where('q.date BETWEEN :startDate AND :endDate')
            ->andWhere('q.status = :status')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->setParameter('status', AbstractEvent::PLANNED_TYPE)
            ->getQuery()->getResult();
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $events = $this->getEvents($startDate, $endDate);


        foreach ($events as $event) {

            // create an event with a start/end time, or an all day event
            $eventEntity = new EventEntity($this->options['header'] .': '. $event->getCustomer()->getCompany() . PHP_EOL . $event->getInfo(),
                $event->getDate(), $event->getDate());


            $eventEntity->setBgColor($this->options['bgColor']); //set the background color of the event's label

            $eventEntity->setFgColor($this->options['fbColor']); //set the foreground color of the event's label
            //$eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);

        }
    }


}