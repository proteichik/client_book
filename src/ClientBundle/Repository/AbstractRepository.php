<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository implements FilterRepositoryInterface
{
    public function getFilteredBuilder()
    {
        return $this->createQueryBuilder('e');
    }
}