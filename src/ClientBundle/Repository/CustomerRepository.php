<?php

namespace ClientBundle\Repository;

class CustomerRepository extends AbstractRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT c, u FROM ClientBundle:Customer c JOIN c.user u');

        return $query->getResult();
    }

    public function getFilteredBuilder()
    {
        return $this->createQueryBuilder('c')
            ->join('c.user', 'u');
    }


}