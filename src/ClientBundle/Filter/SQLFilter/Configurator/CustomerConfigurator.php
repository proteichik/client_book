<?php

namespace ClientBundle\Filter\SQLFilter\Configurator;

use ClientBundle\Controller\Base\BaseEventController;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class CustomerConfigurator
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param ObjectManager $em
     * @param Reader $reader
     */
    public function __construct(ObjectManager $em, Reader $reader)
    {
        $this->em = $em;
        $this->reader = $reader;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return null;
        }

        if (!$controller[0] instanceof BaseEventController) {
            return null;
        }

        if (!$controller[1] === 'listAction') {
            return null;
        }

        $id = $event->getRequest()->attributes->get('id_customer', false);

        if ($id) {
            $filter = $this->em->getFilters()->enable('customer_filter');
            $filter->setParameter('id', $id);
            $filter->setAnnotationReader($this->reader);
            $filter->setAnnotation('ClientBundle\\Annotation\\CustomerSelect');
        }
    }


}