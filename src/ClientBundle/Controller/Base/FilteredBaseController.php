<?php

namespace ClientBundle\Controller\Base;

use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Traits\FilterFormTrait;

class FilteredBaseController extends AbstractController
{
    use FilterFormTrait;

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