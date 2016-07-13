<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Exception\InvalidFormException;
use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * AbstractController constructor.
     * @param ServiceInterface $service
     * @param $form
     * @param EntityInterface $prototype
     */
    public function __construct(ServiceInterface $service, $form, EntityInterface $prototype)
    {
        $this->service = $service;
        $this->form = $form;
        $this->prototype = $prototype;
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

    /**
     * @param Request $request
     * @param EntityInterface|null $object
     * @param array $options
     * @return \Symfony\Component\Form\Form
     */
    protected function prepareForm(Request $request, EntityInterface $object = null, $options = array())
    {
        $form = $this->createForm($this->getForm(), $object, $options);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param FormInterface $form
     * @return bool
     */
    protected function runSave(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getService()->save($form->getData());

            return true;
        } else {
            return false;
        }
    }
}