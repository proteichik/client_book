<?php

namespace ClientBundle\Service;

use Doctrine\ORM\EntityManager as ObjectManager;

class UsersService implements UsersServiceInterface
{
    /**
     * @var ObjectManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_repositoryName;

    /**
     * UsersService constructor.
     * @param ObjectManager $em
     * @param string $repositoryName
     */
    public function __construct(ObjectManager $em, $repositoryName)
    {
        $this->_em = $em;
        $this->setRepositoryName($repositoryName);
    }

    /**
     * @param string $repositoryName
     */
    public function setRepositoryName($repositoryName)
    {
        if (!is_string($repositoryName)) {
            throw new \InvalidArgumentException('Variable $repositoryName must be a string');
        }

        $this->_repositoryName = $repositoryName;
    }

    /**
     * @param array $options
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function findAllUsers(array $options = array(), $isResult = true)
    {
        $qb = $this->getRepository()->createQueryBuilder('q');

        return ($isResult) ? $qb->getQuery()->getResult() : $qb;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->_em->getRepository($this->_repositoryName);
    }

}