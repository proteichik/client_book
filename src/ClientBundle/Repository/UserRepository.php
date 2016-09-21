<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package ClientBundle\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function getCountCustomers($id, array $options = array())
    {
        $keyCustomers = (isset($options['key'])) ? $options['key'] : 'countCustomers';

        return $this->createQueryBuilder('q')
            ->join('q.customers', 'c')
            ->addSelect('count(c.id) as ' . $keyCustomers)
            ->where('q.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult(AbstractQuery::HYDRATE_ARRAY)
            ;
    }
}