<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package ClientBundle\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param $id
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersById($id, $isResult = true)
    {
        $qb = $this->getUsersWithCustomers(false);

        $qb->where('q.id = :id')->setParameter('id', $id);

        return ($isResult) ? $qb->getQuery()->getSingleResult() : $qb;
    }

    /**
     * @param $username
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersByUsername($username, $isResult = true)
    {
        $qb = $this->getUsersWithCustomers(false);

        $qb->where('q.username = :username')->setParameter('username', $username);

        return ($isResult) ? $qb->getQuery()->getSingleResult() : $qb;
    }

    /**
     * @param $emailCanonical
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersByEmail($emailCanonical, $isResult = true)
    {
        $qb = $this->getUsersWithCustomers(false);

        $qb->where('q.emailCanonical = :emailCanonical')->setParameter('emailCanonical', $emailCanonical);

        return ($isResult) ? $qb->getQuery()->getSingleResult() : $qb;
    }

    /**
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUsersWithCustomers($isResult = true)
    {
        $qb = $this->createQueryBuilder('q')
            ->join('q.customers', 'c')
        ;

        return ($isResult) ? $qb->getQuery()->getResult() : $qb;
    }
}