<?php

namespace ClientBundle\Service;

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
     * @return mixed
     */
    public function remove($object);

    /**
     * @param $object
     * @return void
     */
    public function persist($object);

    /**
     * @return void
     */
    public function flush();
}