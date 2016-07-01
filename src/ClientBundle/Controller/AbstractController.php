<?php

namespace Juglon\AdminBundle\Controller;

use Juglon\AdminBundle\Model\AbstractEntity;
use Juglon\AdminBundle\Service\BaseService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @var BaseService
     */
    protected $service;

    /**
     * @var string
     */
    protected $form;

    /**
     * @var AbstractEntity
     */
    protected $prototype;


    /**
     * @param BaseService $service
     * @param string $form
     * @param AbstractEntity $prototype
     */
    public function __construct(BaseService $service, $form, AbstractEntity $prototype)
    {
        $this->service = $service;
        $this->form = $form;
        $this->prototype = $prototype;
    }

    /**
     * @param BaseService $service
     * @return $this
     */
    public function setService(BaseService $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return BaseService
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
     * @param AbstractEntity  $prototype
     * @return $this
     */
    public function setPrototype(AbstractEntity $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * @return AbstractEntity
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