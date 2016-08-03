<?php

namespace ClientBundle\Listener\EventListener;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarMeetingEventListener extends EventCalendarListener
{
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'header' => '[Встреча]',
//            'bgColorDone' => '#39676f',
//            'bgColorPlan' => '#de8069',
        ));
    }
}