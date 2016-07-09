<?php
namespace ClientBundle\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

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


}