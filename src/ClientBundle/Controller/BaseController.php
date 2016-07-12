<?php
namespace ClientBundle\Controller;

use ClientBundle\Exception\InvalidFormException;
use ClientBundle\Model\EntityInterface;
use ClientBundle\Model\Route;
use ClientBundle\Service\ServiceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{

    /**
     * @var array
     */
    protected $routes = array();

    /**
     * @param ServiceInterface $service
     * @param string $form
     * @param EntityInterface $prototype
     * @param string $filterFormClass
     */
    public function __construct(ServiceInterface $service, $form, EntityInterface $prototype, $filterFormClass)
    {
        parent::__construct($service, $form, $prototype, $filterFormClass);
        $this->routes = $this->setRoutes();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filterForm = $this->createForm($this->filterFormClass);

        if ($request->query->has($filterForm->getName())) {

            $filterForm->submit($request->query->get($filterForm->getName()));
            $objects = $this->getService()->getFilteredList($filterForm);
        } else {
            $objects = $this->getService()->findAll();
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'objects' => $objects,
            'filterForm' => $filterForm->createView()));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->prepareForm($request, $this->getPrototype());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getService()->save($form->getData());
            $routeTo = $this->getRoute(__FUNCTION__);

            return $this->redirectToRoute($routeTo->getRoute(), $routeTo->getParams(), $routeTo->getCode());
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView()));

    }

    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $object = $this->getService()->find($id);

        if (!$object) {
            throw new \InvalidArgumentException('Object not found');
        }

        $form = $this->prepareForm($request, $object);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getService()->save($form->getData());
            $routeTo = $this->getRoute(__FUNCTION__);

            return $this->redirectToRoute($routeTo->getRoute(), $routeTo->getParams(), $routeTo->getCode());
        }

        return $this->render($this->getTemplateName($this, __METHOD__), array('form' => $form->createView()));
    }
    

    /**
     * @param $name
     * @return Route
     */
    protected function getRoute($name)
    {
        $route = new Route();

        if (isset($this->routes[$name]))
        {
            $route->exchangeArray($this->routes[$name]);
        }

        return $route;
    }

    abstract protected function setRoutes();

}