<?php

namespace ClientBundle\Filter\SQLFilter\Configurator;

use ClientBundle\Entity\AbstractEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Annotations\Reader;
use ClientBundle\Utils\UserUtils;

/**
 * Class Configurator
 * @package ClientBundle\Filter
 */
class StatusConfigurator
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

    /**
     * Method handle kernel request
     *
     * @return null
     */
    public function onKernelRequest()
    {
        $filter = $this->em->getFilters()->enable('status_filter');
        $filter->setParameter('status', AbstractEvent::REMOVED_TYPE);

        $filter->setAnnotationReader($this->reader);
        $filter->setAnnotation('ClientBundle\\Annotation\\HasStatusFilter');

    }
}