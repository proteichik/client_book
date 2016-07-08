<?php

namespace ClientBundle\Filter\SQLFilter;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Annotations\Reader;
use ClientBundle\Utils\UserUtils;

/**
 * Class Configurator
 * @package ClientBundle\Filter
 */
class Configurator
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param ObjectManager $em
     * @param TokenStorageInterface $tokenStorage
     * @param Reader $reader
     */
    public function __construct(ObjectManager $em, TokenStorageInterface $tokenStorage, Reader $reader)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->reader = $reader;
    }

    /**
     * Method handle kernel request
     *
     * @return null
     */
    public function onKernelRequest()
    {
        $user = $this->getUser();

        if (!$user) {
            return null;
        }

        if (!$user->hasRole('ROLE_ADMIN')) {
            $filter = $this->em->getFilters()->enable('user_filter');
            $filter->setParameter('id', $user->getId());
            $filter->setAnnotationReader($this->reader);
        }
    }

    /**
     * @return UserInterface|null
     */
    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}