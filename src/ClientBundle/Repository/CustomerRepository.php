<?php

namespace ClientBundle\Repository;

class CustomerRepository extends AbstractRepository
{
    public function getQueryAllBuilder()
    {
        return $this->createQueryBuilder('q')
            ->join('q.user', 'u');

//        return $this->_em->createQueryBuilder()
//            ->select(array('q', 'u'))
//            ->from($this->_entityName, 'q')
//            ->join('q.user', 'u')
//        ;
    }
}