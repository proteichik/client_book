<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class FilteredBaseController extends AbstractController
{
    /**
     * @var string
     */
    protected $filterFormClass;

    /**
     * @param ServiceInterface $service
     * @param $form
     * @param EntityInterface $prototype
     * @param PaginatorInterface $paginator
     * @param $filterFormClass
     */
    public function __construct(ServiceInterface $service, $form, EntityInterface $prototype,
                                PaginatorInterface $paginator, $filterFormClass)
    {
        parent::__construct($service, $form, $prototype, $paginator);

        $this->setFilterFormClass($filterFormClass);
    }


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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filterForm = $this->createForm($this->filterFormClass);

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