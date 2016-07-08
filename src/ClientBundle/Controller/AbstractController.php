<?php

namespace ClientBundle\Controller;

use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * @var string
     */
    protected $form;

    /**
     * @var EntityInterface
     */
    protected $prototype;

    /**
     * @var string
     */
    protected $filterFormClass;

    /**
     * @return string
     */
    public function getFilterFormClass()
    {
        return $this->filterFormClass;
    }

    /**
     * @param $filterFormClass
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFilterFormClass($filterFormClass)
    {
        if (!is_string($filterFormClass)) {
            throw new \InvalidArgumentException('Form filter must be a string');
        }

        $this->filterFormClass = $filterFormClass;

        return $this;
    }


    /**
     * @param ServiceInterface $service
     * @param string $form
     * @param EntityInterface $prototype
     * @param string $filterFormClass
     */
    public function __construct(ServiceInterface $service, $form, EntityInterface $prototype, $filterFormClass)
    {
        $this->service = $service;
        $this->form = $form;
        $this->prototype = $prototype;
        $this->setFilterFormClass($filterFormClass);
    }

    /**
     * @param ServiceInterface $service
     * @return $this
     */
    public function setService(ServiceInterface $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $form
     * @return $this
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param EntityInterface  $prototype
     * @return $this
     */
    public function setPrototype(EntityInterface $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * @return EntityInterface
     */
    public function getPrototype()
    {
        return $this->prototype;
    }


    /**
     * @param $object
     * @return string
     */
    protected function getClassName($object)
    {
        $className = implode('', array_slice(explode('\\', get_class($object)), -1));
        $className = str_replace('Controller', '', $className);

        return $this->convertCamelCaseName($className);
    }

    /**
     * @param $action
     * @return string
     */
    protected function getActionName($action)
    {
        $action = implode('', array_slice(explode('::', $action), -1));
        $action = str_replace('Action', '', $action);

        return $this->convertCamelCaseName($action);
    }

    /**
     * @param $name
     * @return string
     */
    protected function convertCamelCaseName($name)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));
    }

    /**
     * @param $object
     * @param $actionName
     * @param string $content
     * @param string $templating
     * @return string
     */
    protected function getTemplateName($object, $actionName, $content = 'html', $templating = 'twig')
    {
        $className = $this->getClassName($object);
        $actionName = $this->getActionName($actionName);

        return $className . '/' . $actionName . '.'. $content . '.' .$templating;
    }




}