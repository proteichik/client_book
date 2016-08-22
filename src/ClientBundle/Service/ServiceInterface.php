<?php

namespace ClientBundle\Service;
use ClientBundle\Model\EntityInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Interface ServiceInterface
 * @package ClientBundle\Service
 */
interface ServiceInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param array $options
     * @return mixed
     */
    public function findBy($options = array());

    /**
     * @param $object
     * @return mixed
     */
    public function save($object);

    /**
     * @param $object
     * @param bool $isFlush
     * @return mixed
     */
    public function remove($object, $isFlush = true);

    /**
     * @param $object
     * @return void
     */
    public function persist($object);

    /**
     * @return void
     */
    public function flush();

    /**
     * @param EntityInterface $object
     * @param bool $isFlush
     * @return mixed
     */
    public function delete(EntityInterface $object, $isFlush = true);

    /**
     * @param $alias
     * @return mixed
     */
    public function getQueryBuilder($alias);

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository();
}