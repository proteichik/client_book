<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository implements FilterRepositoryInterface, InternalRepositoryInterface
{
    public function getQueryAllBuilder()
    {
        return $this->createQueryBuilder('q');
    }

    public function getFilteredBuilder()
    {
        return $this->getQueryAllBuilder();
    }


}