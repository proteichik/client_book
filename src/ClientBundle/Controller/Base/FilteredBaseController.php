<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class FilteredBaseController extends AbstractController
{
    /**
     * @var array
     */
    protected $filterFormClasses = array();

    /**
     * @param array $filterFormClass
     * @return $this
     */
    public function addFilterFormClass(array $filterFormClass = array())
    {
        if (!isset($filterFormClass['name']) || !isset($filterFormClass['class'])) {
            throw new \InvalidArgumentException('Filter format invalid');
        }

        $this->filterFormClasses[$filterFormClass['name']] = $filterFormClass['class'];

        return $this;
    }

    /**
     * @return array
     */
    public function getFilterFormClasses()
    {
        return $this->filterFormClasses;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getFilterFormClass($name)
    {
        if (!$this->hasFilterFormClass($name)) {
            throw new \InvalidArgumentException(sprintf('Filter %s not found', $name));
        }

        return $this->filterFormClasses[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFilterFormClass($name)
    {
        return (isset($this->filterFormClasses[$name]));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filterForm = $this->createForm($this->getFilterFormClass('list'));

        if ($request->query->has($filterForm->getName())) {

            $filterForm->submit($request->query->get($filterForm->getName()));
            $query = $this->getService()->getFilteredList($filterForm);
            
        } else {
            $query = $this->getService()->findAll();
        }

        $objects = $this->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/
        );

        return $this->render($this->getTemplateName($this, __METHOD__), array(
            'objects' => $objects,
            'filterForm' => $filterForm->createView()));
    }
}