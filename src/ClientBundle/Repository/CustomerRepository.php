<?php

namespace ClientBundle\Repository;

class CustomerRepository extends AbstractRepository
{
    public function getQueryAllBuilder()
    {
        return $this->createQueryBuilder('q')
            ->join('q.user', 'u');
    }
}