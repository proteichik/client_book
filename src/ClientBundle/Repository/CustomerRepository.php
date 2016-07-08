<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT c, u FROM ClientBundle:Customer c JOIN c.user u');

        return $query->getResult();
    }

}